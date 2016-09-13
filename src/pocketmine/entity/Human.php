<?php
namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityRegainHealthEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerExperienceChangeEvent;
use pocketmine\inventory\InventoryHolder;
use pocketmine\inventory\PlayerInventory;
use pocketmine\item\Item as ItemItem;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\LongTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\network\protocol\AddPlayerPacket;
use pocketmine\network\protocol\RemoveEntityPacket;
use pocketmine\Player;
use pocketmine\math\Math;
use pocketmine\utils\UUID;

class Human extends Creature implements ProjectileSource, InventoryHolder{

	const DATA_PLAYER_FLAG_SLEEP = 1;
	const DATA_PLAYER_FLAG_DEAD = 2;

	const DATA_PLAYER_FLAGS = 16;
	const DATA_PLAYER_BED_POSITION = 17;

	/** @var PlayerInventory */
	protected $inventory;

	/** @var UUID */
	protected $uuid;
	protected $rawUUID;

	public $width = 0.6;
	public $length = 0.6;
	public $height = 1.8;
	public $eyeHeight = 1.62;

	protected $skinId;
	protected $skin;

	protected $foodTickTimer = 0;

 	protected $totalXp = 0;
  	protected $xpSeed;
	protected $xpCooldown = 0;

	public function getSkinData(){
		return $this->skin;
	}

	public function getSkinId(){
		return $this->skinId;
	}

	/**
	 * @return UUID|null
	 */
	public function getUniqueId(){
		return $this->uuid;
	}

	/**
	 * @return string
	 */
	public function getRawUniqueId(){
		return $this->rawUUID;
	}

	/**
	 * @param string $str
	 * @param string $skinId
	 */
	public function setSkin($str, $skinId){
		$this->skin = $str;
		$this->skinId = $skinId;
	}

	public function getFood(){
		return $this->attributeMap->getAttribute(Attribute::HUNGER)->getValue();
	}

	/**
	 * WARNING: This method does not check if full and may throw an exception if out of bounds.
	 * Use {@link Human::addFood()} for this purpose
	 *
	 * @param float $new
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setFood(float $new){
		$attr = $this->attributeMap->getAttribute(Attribute::HUNGER);
		$old = $attr->getValue();
		$attr->setValue($new);
		// ranges: 18-20 (regen), 7-17 (none), 1-6 (no sprint), 0 (health depletion)
		foreach([17, 6, 0] as $bound){
			if(($old > $bound) !== ($new > $bound)){
				$reset = true;
			}
		}
		if(isset($reset)){
			$this->foodTickTimer = 0;
		}
	}

	public function getMaxFood(){
		return $this->attributeMap->getAttribute(Attribute::HUNGER)->getMaxValue();
	}

	public function addFood(float $amount){
		$attr = $this->attributeMap->getAttribute(Attribute::HUNGER);
		$amount += $attr->getValue();
		$amount = max(min($amount, $attr->getMaxValue()), $attr->getMinValue());
		$this->setFood($amount);
	}

	public function getSaturation(){
		return $this->attributeMap->getAttribute(Attribute::SATURATION)->getValue();
	}

	/**
	 * WARNING: This method does not check if saturated and may throw an exception if out of bounds.
	 * Use {@link Human::addSaturation()} for this purpose
	 *
	 * @param float $saturation
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setSaturation(float $saturation){
		$this->attributeMap->getAttribute(Attribute::SATURATION)->setValue($saturation);
	}

	public function addSaturation(float $amount){
		$attr = $this->attributeMap->getAttribute(Attribute::SATURATION);
		$amount += $attr->getValue();
		$amount = max(min($amount, $attr->getMaxValue()), $attr->getMinValue());
		$this->setSaturation($amount);
	}

	public function getExhaustion(){
		return $this->attributeMap->getAttribute(Attribute::EXHAUSTION)->getValue();
	}

	/**
	 * WARNING: This method does not check if exhausted and does not consume saturation/food.
	 * Use {@link Human::exhaust()} for this purpose.
	 *
	 * @param float $exhaustion
	 */
	public function setExhaustion(float $exhaustion){
		$this->attributeMap->getAttribute(Attribute::EXHAUSTION)->setValue($exhaustion);
	}

	/**
	 * Increases a human's exhaustion level.
	 *
	 * @param float $amount
	 * @param int   $cause
	 *
	 * @return float the amount of exhaustion level increased
	 */
	public function exhaust(float $amount, int $cause = PlayerExhaustEvent::CAUSE_CUSTOM){
		$this->server->getPluginManager()->callEvent($ev = new PlayerExhaustEvent($this, $amount, $cause));
		if($ev->isCancelled()){
			return 0.0;
		}

		$exhaustion = $this->getExhaustion();
		$exhaustion += $ev->getAmount();

		while($exhaustion >= 4.0){
			$exhaustion -= 4.0;

			$saturation = $this->getSaturation();
			if($saturation > 0){
				$saturation = max(0, $saturation - 1.0);
				$this->setSaturation($saturation);
			}else{
				$food = $this->getFood();
				if($food > 0){
					$food--;
					$this->setFood($food);
				}
			}
		}
		$this->setExhaustion($exhaustion);

		return $ev->getAmount();
	}

	public function getXpLevel(){
		return (int) $this->attributeMap->getAttribute(Attribute::EXPERIENCE_LEVEL)->getValue();
	}

	public function setXpLevel(int $level){
		$this->server->getPluginManager()->callEvent($ev = new PlayerExperienceChangeEvent($this, $level, $this->getXpProgress()));
		if(!$ev->isCancelled()){
			$this->attributeMap->getAttribute(Attribute::EXPERIENCE_LEVEL)->setValue($ev->getExpLevel());
			return true;
		}
		return false;
	}

	public function addXpLevel(int $level){
		return $this->setXpLevel($this->getXpLevel() + $level);
	}

	public function takeXpLevel(int $level){
		return $this->setXpLevel($this->getXpLevel() - $level);
	}

	public function getXpProgress(){
		return $this->attributeMap->getAttribute(Attribute::EXPERIENCE)->getValue();
	}

	public function setXpProgress(float $progress){
		$this->attributeMap->getAttribute(Attribute::EXPERIENCE)->setValue($progress);
		return true;
	}

	public function getTotalXp(){
		return $this->totalXp;
	}

	/**
	 * Changes the total exp of a player
	 *
	 * @param int $xp 
	 * @param bool $syncLevel
	 * This will reset the level to be in sync with the total. Usually you don't want to do this,
	 * because it'll mess up use of xp in anvils and enchanting tables.
	 * 
	 * @return bool
	 */
	public function setTotalXp(int $xp, bool $syncLevel = false){
		$xp &= 0x7fffffff;
		if($xp === $this->totalXp){
			return false;
		}
		if(!$syncLevel){
			$level = $this->getXpLevel();
			$diff = $xp - $this->totalXp + $this->getFilledXp();
			if($diff > 0){
				while($diff > ($v = self::getLevelXpRequirement($level))){
					$diff -= $v;
					if(++$level >= 21863){
						$diff = $v; // fill exp bar
						break;
					}
				}
			}
			else{
				while($diff < ($v = self::getLevelXpRequirement($level - 1))){
					$diff += $v;
					if(--$level <= 0){
						$diff = 0;
						break;
					}
				}
			}
			$progress = ($diff / $v);
		}
		else{
			$values = self::getLevelFromXp($xp);
			$level = $values[0];
			$progress = $values[1];
		}
		$this->server->getPluginManager()->callEvent($ev = new PlayerExperienceChangeEvent($this, $level, $progress));
		if(!$ev->isCancelled()){
			$this->setXpLevel($ev->getExpLevel());
			$this->setXpProgress($ev->getProgress());
			return true;
		}
		return false;
	}

	public function addXp(int $xp, bool $syncLevel = false){
		return $this->setTotalXp($this->totalXp + $xp, $syncLevel);
	}

	public function takeXp(int $xp, bool $syncLevel = false){
		return $this->setTotalXp($this->totalXp - $xp, $syncLevel);
	}

	public function getRemainderXp(){
		return self::getLevelXpRequirement($this->getXpLevel()) - $this->getFilledXp();
	}

	public function getFilledXp(){
		return self::getLevelXpRequirement($this->getXpLevel()) * $this->getXpProgress();
	}

	public function recalculateXpProgress(){
		$this->setXpProgress($this->getRemainderXp() / self::getLevelXpRequirement($this->getXpLevel()));
	}

	public function getXpSeed(){
		// TODO: use this for randomizing enchantments in enchanting tables
		return $this->xpSeed;
	}

	public function resetXpCooldown(){
		$this->xpCooldown = microtime(true);
	}

	public function canPickupXp(): bool{
		return microtime(true) - $this->xpCooldown > 0.5;
	}

	/**
	 * Returns the total amount of exp required to reach the specified level.
	 *
	 * @param int $level 
	 *
	 * @return int
	 */
	public static function getTotalXpRequirement(int $level){
		if($level <= 16){
			return ($level ** 2) + (6 * $level);
		}
		elseif($level <= 31){
			return (2.5 * ($level ** 2)) - (40.5 * $level) + 360;
		}
		elseif($level <= 21863){
			return (4.5 * ($level ** 2)) - (162.5 * $level) + 2220;
		}
		return PHP_INT_MAX; // prevent float returns for invalid levels on 32-bit systems
	}

	/**
	 * Returns the amount of exp required to complete the specified level.
	 *
	 * @param int $level 
	 *
	 * @return int
	 */
	public static function getLevelXpRequirement(int $level){
		if($level <= 16){
			return (2 * $level) + 7;
		}
		elseif($level <= 31){
			return (5 * $level) - 38;
		}
		elseif($level <= 21863){
			return (9 * $level) - 158;
		}
		return PHP_INT_MAX;
	}

	/**
	 * Converts a quantity of exp into a level and a progress percentage
	 *
	 * @param int $xp 
	 *
	 * @return int[]
	 */
	public static function getLevelFromXp(int $xp){
		$xp &= 0x7fffffff;
		/**
		 * These values are correct up to and including level 16
		 */
		$a = 1;
		$b = 6;
		$c = -$xp;
		if($xp > self::getTotalXpRequirement(16)){
			/**
			 * Modify the coefficients to fit the relevant equation
			 */
			if($xp <= self::getTotalXpRequirement(31)){
				/**
				 * Levels 16-31
				 */
				$a = 2.5;
				$b = -40.5;
				$c += 360;
			}
			else{
				/**
				 * Level 32+
				 */
				$a = 4.5;
				$b = -162.5;
				$c += 2220;
			}
		}
		$answer = max(Math::solveQuadratic($a, $b, $c)); // Use largest result value
		$level = floor($answer);
		$progress = $answer - $level;
		return [$level, $progress];
	}

	public function getInventory(){
		return $this->inventory;
	}

	protected function initEntity(){

		$this->setDataFlag(self::DATA_PLAYER_FLAGS, self::DATA_PLAYER_FLAG_SLEEP, false);
		$this->setDataProperty(self::DATA_PLAYER_BED_POSITION, self::DATA_TYPE_POS, [0, 0, 0], false);

		$this->inventory = new PlayerInventory($this);
		if($this instanceof Player){
			$this->addWindow($this->inventory, 0);
		}else{
			if(isset($this->namedtag->NameTag)){
				$this->setNameTag($this->namedtag["NameTag"]);
			}

			if(isset($this->namedtag->Skin) and $this->namedtag->Skin instanceof CompoundTag){
				$this->setSkin($this->namedtag->Skin["Data"], $this->namedtag->Skin["Name"]);
			}

			$this->uuid = UUID::fromData($this->getId(), $this->getSkinData(), $this->getNameTag());
		}

		if(isset($this->namedtag->Inventory) and $this->namedtag->Inventory instanceof ListTag){
			foreach($this->namedtag->Inventory as $item){
				if($item["Slot"] >= 0 and $item["Slot"] < 9){ //Hotbar
					$this->inventory->setHotbarSlotIndex($item["Slot"], isset($item["TrueSlot"]) ? $item["TrueSlot"] : -1);
				}elseif($item["Slot"] >= 100 and $item["Slot"] < 104){ //Armor
					$this->inventory->setItem($this->inventory->getSize() + $item["Slot"] - 100, NBT::getItemHelper($item));
				}else{
					$this->inventory->setItem($item["Slot"] - 9, NBT::getItemHelper($item));
				}
			}
		}

		parent::initEntity();

		if(!isset($this->namedtag->foodLevel) or !($this->namedtag->foodLevel instanceof IntTag)){
			$this->namedtag->foodLevel = new IntTag("foodLevel", $this->getFood());
		}else{
			$this->setFood($this->namedtag["foodLevel"]);
		}

		if(!isset($this->namedtag->foodExhaustionLevel) or !($this->namedtag->foodExhaustionLevel instanceof IntTag)){
			$this->namedtag->foodExhaustionLevel = new FloatTag("foodExhaustionLevel", $this->getExhaustion());
		}else{
			$this->setExhaustion($this->namedtag["foodExhaustionLevel"]);
		}

		if(!isset($this->namedtag->foodSaturationLevel) or !($this->namedtag->foodSaturationLevel instanceof IntTag)){
			$this->namedtag->foodSaturationLevel = new FloatTag("foodSaturationLevel", $this->getSaturation());
		}else{
			$this->setSaturation($this->namedtag["foodSaturationLevel"]);
		}

		if(!isset($this->namedtag->foodTickTimer) or !($this->namedtag->foodTickTimer instanceof IntTag)){
			$this->namedtag->foodTickTimer = new IntTag("foodTickTimer", $this->foodTickTimer);
		}else{
			$this->foodTickTimer = $this->namedtag["foodTickTimer"];
		}
		if(!isset($this->namedtag->XpLevel) or !($this->namedtag->XpLevel instanceof IntTag)){
			$this->namedtag->XpLevel = new IntTag("XpLevel", 0);
		}
		$this->setXpLevel($this->namedtag["XpLevel"]);
		if(!isset($this->namedtag->XpP) or !($this->namedtag->XpP instanceof FloatTag)){
			$this->namedtag->XpP = new FloatTag("XpP", 0);
		}
		$this->setXpProgress($this->namedtag["XpP"]);
		if(!isset($this->namedtag->XpTotal) or !($this->namedtag->XpTotal instanceof IntTag)){
			$this->namedtag->XpTotal = new IntTag("XpTotal", 0);
		}
		$this->totalXp = $this->namedtag["XpTotal"];
		if(!isset($this->namedtag->XpSeed) or !($this->namedtag->XpSeed instanceof IntTag)){
			$this->namedtag->XpSeed = new IntTag("XpSeed", mt_rand(PHP_INT_MIN, PHP_INT_MAX));
		}
		$this->xpSeed = $this->namedtag["XpSeed"];
	}

	protected function addAttributes(){
		parent::addAttributes();

		if(is_null($this->attributeMap->getAttribute(Attribute::SATURATION)))$this->attributeMap->addAttribute(Attribute::getAttribute(Attribute::SATURATION));
		if(is_null($this->attributeMap->getAttribute(Attribute::EXHAUSTION)))$this->attributeMap->addAttribute(Attribute::getAttribute(Attribute::EXHAUSTION));
		if(is_null($this->attributeMap->getAttribute(Attribute::HUNGER)))$this->attributeMap->addAttribute(Attribute::getAttribute(Attribute::HUNGER));
		if(is_null($this->attributeMap->getAttribute(Attribute::EXPERIENCE_LEVEL)))$this->attributeMap->addAttribute(Attribute::getAttribute(Attribute::EXPERIENCE_LEVEL));
		if(is_null($this->attributeMap->getAttribute(Attribute::EXPERIENCE)))$this->attributeMap->addAttribute(Attribute::getAttribute(Attribute::EXPERIENCE));
	}

	public function entityBaseTick($tickDiff = 1){
		$hasUpdate = parent::entityBaseTick($tickDiff);

		$food = $this->getFood();
		$health = $this->getHealth();
		if(($this instanceof Player && $this->isSurvival()) || $this instanceof Human){
			if($food >= 18){
				$this->foodTickTimer++;
				if($this->foodTickTimer >= 80 and $health < $this->getMaxHealth()){
					$this->heal(1, new EntityRegainHealthEvent($this, 1, EntityRegainHealthEvent::CAUSE_SATURATION));
					$this->exhaust(3.0, PlayerExhaustEvent::CAUSE_HEALTH_REGEN);
					$this->foodTickTimer = 0;
	
				}
			}elseif($food === 0){
				$this->foodTickTimer++;
				if($this->foodTickTimer >= 80){
					$diff = $this->server->getDifficulty();
					$can = false;
					if($diff === 1){
						$can = $health > 10;
					}elseif($diff === 2){
						$can = $health > 1;
					}elseif($diff === 3){
						$can = true;
					}
					if($can){
						$this->attack(1, new EntityDamageEvent($this, EntityDamageEvent::CAUSE_STARVATION, 1));
					}
				}
			}
			if($food <= 6){
				if($this->isSprinting()){
					$this->setSprinting(false);
				}
			}
		}

		return $hasUpdate;
	}

	public function getName(){
		return $this->getNameTag();
	}

	public function getDrops(){
		$drops = [];
		if($this->inventory !== null){
			foreach($this->inventory->getContents() as $item){
				$drops[] = $item;
			}
		}

		return $drops;
	}

	public function saveNBT(){
		parent::saveNBT();
		$this->namedtag->foodLevel = new IntTag("foodLevel", $this->getFood());
		$this->namedtag->foodExhaustionLevel = new FloatTag("foodExhaustionLevel", $this->getExhaustion());
		$this->namedtag->foodSaturationLevel = new FloatTag("foodSaturationLevel", $this->getSaturation());
		$this->namedtag->foodTickTimer = new IntTag("foodTickTimer", $this->foodTickTimer);
		$this->namedtag->XpLevel = new IntTag("XpLevel", $this->getXpLevel());
		$this->namedtag->XpP = new FloatTag("XpP", $this->getXpProgress());
		$this->namedtag->XpTotal = new IntTag("XpTotal", $this->totalXp);
		$this->namedtag->XpSeed = new IntTag("XpSeed", $this->xpSeed ?? ($this->xpSeed = mt_rand(PHP_INT_MIN, PHP_INT_MAX)));

		$this->namedtag->Inventory = new ListTag("Inventory", []);
		$this->namedtag->Inventory->setTagType(NBT::TAG_Compound);
		if($this->inventory !== null){
			for($slot = 0; $slot < 9; ++$slot){
				$hotbarSlot = $this->inventory->getHotbarSlotIndex($slot);
				if($hotbarSlot !== -1){
					$item = $this->inventory->getItem($hotbarSlot);
					if($item->getId() !== 0 and $item->getCount() > 0){
						$tag = NBT::putItemHelper($item, $slot);
						$tag->TrueSlot = new ByteTag("TrueSlot", $hotbarSlot);
						$this->namedtag->Inventory[$slot] = $tag;

						continue;
					}
				}

				$this->namedtag->Inventory[$slot] = new CompoundTag("", [
					new ByteTag("Count", 0),
					new ShortTag("Damage", 0),
					new ByteTag("Slot", $slot),
					new ByteTag("TrueSlot", -1),
					new ShortTag("id", 0),
				]);
			}

			//Normal inventory
			$slotCount = Player::SURVIVAL_SLOTS + 9;
			//$slotCount = (($this instanceof Player and ($this->gamemode & 0x01) === 1) ? Player::CREATIVE_SLOTS : Player::SURVIVAL_SLOTS) + 9;
			for($slot = 9; $slot < $slotCount; ++$slot){
				$item = $this->inventory->getItem($slot - 9);
				$this->namedtag->Inventory[$slot] = NBT::putItemHelper($item, $slot);
			}

			//Armor
			for($slot = 100; $slot < 104; ++$slot){
				$item = $this->inventory->getItem($this->inventory->getSize() + $slot - 100);
				if($item instanceof ItemItem and $item->getId() !== ItemItem::AIR){
					$this->namedtag->Inventory[$slot] = NBT::putItemHelper($item, $slot);
				}
			}
		}

		if(strlen($this->getSkinData()) > 0){
			$this->namedtag->Skin = new CompoundTag("Skin", [
				"Data" => new StringTag("Data", $this->getSkinData()),
				"Name" => new StringTag("Name", $this->getSkinId())
			]);
		}
		$this->namedtag->XpLevel = new IntTag("XpLevel", $this->getXpLevel());
		$this->namedtag->XpTotal = new IntTag("XpTotal", $this->getTotalXp());
		$this->namedtag->XpP = new FloatTag("XpP", $this->getXpProgress());
		$this->namedtag->XpSeed = new IntTag("XpSeed", $this->getXpSeed());
	}

	public function spawnTo(Player $player){
		if($player !== $this and !isset($this->hasSpawned[$player->getLoaderId()])){
			$this->hasSpawned[$player->getLoaderId()] = $player;

			if(strlen($this->skin) < 64 * 32 * 4){
				throw new \InvalidStateException((new \ReflectionClass($this))->getShortName() . " must have a valid skin set");
			}


			if(!($this instanceof Player)){
				$this->server->updatePlayerListData($this->getUniqueId(), $this->getId(), $this->getName(), $this->skinId, $this->skin, [$player]);
			}

			$pk = new AddPlayerPacket();
			$pk->uuid = $this->getUniqueId();
			$pk->username = $this->getName();
			$pk->eid = $this->getId();
			$pk->x = $this->x;
			$pk->y = $this->y;
			$pk->z = $this->z;
			$pk->speedX = $this->motionX;
			$pk->speedY = $this->motionY;
			$pk->speedZ = $this->motionZ;
			$pk->yaw = $this->yaw;
			$pk->pitch = $this->pitch;
			$pk->item = $this->getInventory()->getItemInHand();
			$pk->metadata = $this->dataProperties;
			$player->dataPacket($pk);
			
			$this->inventory->sendArmorContents($player);

			if(!($this instanceof Player)){
				$this->server->removePlayerListData($this->getUniqueId(), [$player]);
			}
		}
	}

	public function despawnFrom(Player $player){
		if(isset($this->hasSpawned[$player->getLoaderId()])){

			$pk = new RemoveEntityPacket();
			$pk->eid = $this->getId();

			$player->dataPacket($pk);
			unset($this->hasSpawned[$player->getLoaderId()]);
		}
	}

	public function close(){
		if(!$this->closed){
			if(!($this instanceof Player) or $this->loggedIn){
				foreach($this->inventory->getViewers() as $viewer){
					$viewer->removeWindow($this->inventory);
				}
			}
			parent::close();
		}
	}

}
