<?php

namespace pocketmine\tile;

use pocketmine\inventory\BrewingInventory;
use pocketmine\inventory\InventoryHolder;
use pocketmine\item\Item;
use pocketmine\item\Fish;
use pocketmine\level\format\FullChunk;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\network\protocol\ContainerSetDataPacket;
use pocketmine\Server;

class BrewingStand extends Spawnable implements InventoryHolder, Container, Nameable{
	const MAX_BREW_TIME = 400;
	/** @var BrewingInventory */
	protected $inventory;

	public static $ingredients = [
		Item::NETHER_WART => 0,
		Item::GLOWSTONE_DUST => 0,
		Item::REDSTONE => 0,
		Item::FERMENTED_SPIDER_EYE => 0,

		Item::MAGMA_CREAM => 0,
		Item::SUGAR => 0,
		Item::GLISTERING_MELON => 0,
		Item::SPIDER_EYE => 0,
		Item::GHAST_TEAR => 0,
		Item::BLAZE_POWDER => 0,
		Item::GOLDEN_CARROT => 0,
		Item::PUFFERFISH => 0,
		Item::RABBIT_FOOT => 0,

		Item::GUNPOWDER => 0,
	];

	public function __construct(FullChunk $chunk, CompoundTag $nbt){
		parent::__construct($chunk, $nbt);
		$this->inventory = new BrewingInventory($this);

		if(!isset($this->namedtag->Items) or !($this->namedtag->Items instanceof ListTag)){
			$this->namedtag->Items = new ListTag("Items", []);
			$this->namedtag->Items->setTagType(NBT::TAG_Compound);
		}

		for($i = 0; $i < $this->getSize(); ++$i){
			$this->inventory->setItem($i, $this->getItem($i));
		}

		if(!isset($this->namedtag->BrewTime)){
			$this->namedtag->BrewTime = new ShortTag("BrewTime", 0);
		}

		/*if($this->namedtag["BrewTime"] < self::MAX_BREW_TIME){
			$this->scheduleUpdate();
		}*/
	}

	public function getName(){
		return $this->hasName() ? $this->namedtag->CustomName->getValue() : "Brewing Stand";
	}

	public function hasName(){
		return isset($this->namedtag->CustomName);
	}

	public function setName($str){
		if($str === ""){
			unset($this->namedtag->CustomName);
			return;
		}

		$this->namedtag->CustomName = new StringTag("CustomName", $str);
	}

	public function close(){
		if($this->closed === false){
			foreach($this->getInventory()->getViewers() as $player){
				$player->removeWindow($this->getInventory());
			}
			parent::close();
		}
	}

	public function saveNBT(){
		$this->namedtag->Items = new ListTag("Items", []);
		$this->namedtag->Items->setTagType(NBT::TAG_Compound);
		for($index = 0; $index < $this->getSize(); ++$index){
			$this->setItem($index, $this->inventory->getItem($index));
		}
	}

	/**
	 * @return int
	 */
	public function getSize(){
		return 4;
	}

	/**
	 * @param $index
	 *
	 * @return int
	 */
	protected function getSlotIndex($index){
		foreach($this->namedtag->Items as $i => $slot){
			if($slot["Slot"] === $index){
				return $i;
			}
		}

		return -1;
	}

	/**
	 * This method should not be used by plugins, use the Inventory
	 *
	 * @param int $index
	 *
	 * @return Item
	 */
	public function getItem($index){
		$i = $this->getSlotIndex($index);
		if($i < 0){
			return Item::get(Item::AIR, 0, 0);
		}else{
			return NBT::getItemHelper($this->namedtag->Items[$i]);
		}
	}

	/**
	 * This method should not be used by plugins, use the Inventory
	 *
	 * @param int  $index
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function setItem($index, Item $item){
		$i = $this->getSlotIndex($index);

		$d = NBT::putItemHelper($item, $index);

		if($item->getId() === Item::AIR or $item->getCount() <= 0){
			if($i >= 0){
				unset($this->namedtag->Items[$i]);
			}
		}elseif($i < 0){
			for($i = 0; $i <= $this->getSize(); ++$i){
				if(!isset($this->namedtag->Items[$i])){
					break;
				}
			}
			$this->namedtag->Items[$i] = $d;
		}else{
			$this->namedtag->Items[$i] = $d;
		}

		return true;
	}

	/**
	 * @return BrewingInventory
	 */
	public function getInventory(){
		return $this->inventory;
	}

	public function checkIngredient(Item $item){
		if(isset(self::$ingredients[$item->getId()])){
			if(self::$ingredients[$item->getId()] === $item->getDamage()){
				return true;
			}
		}
		return false;
	}

	public function updateSurface(){
		$this->saveNBT();
		$this->spawnToAll();
		if($this->chunk){
			$this->chunk->setChanged();
			$this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
		}
	}

	public function onUpdate(){
		if($this->closed === true){
			return false;
		}

		$this->timings->startTiming();

		$ret = false;

		$ingredient = $this->inventory->getIngredient();
		$product = $this->inventory->getResult();
		$brew = $this->server->getCraftingManager()->matchBrewingRecipe($ingredient);
		$canbrew = ($brew instanceof BrewingRecipe and $ingredient->getCount() > 0 and (($brew->getResult()->equals($product) and $product->getCount() < $product->getMaxStackSize()) or $product->getId() === Item::AIR));

		$this->namedtag->BrewTime = new ShortTag("BrewTime", $this->namedtag["BrewTime"] - 1);
		$this->namedtag->BrewTicks = new ShortTag("BrewTicks", 0);

		if($brew instanceof BrewingRecipe and $canbrew){


				$product = Item::get($brew->getResult()->getId(), $brew->getResult()->getDamage(), $product->getCount() + 1);

				$this->server->getPluginManager()->callEvent($ev = new BrewingStandBrewEvent($this, $ingredient, $product));

				if(!$ev->isCancelled()){

					$this->inventory->setResult($ev->getResult());
					$ingredient->setCount($ingredient->getCount() - 1);
					if($ingredient->getCount() === 0){
						$ingredient = Item::get(Item::AIR, 0, 0);
					}
					$canBrew = false;
				}
		}else{
			$canBrew = false;
		}

		if($canBrew){
			$this->namedtag->BrewTime = new ShortTag("BrewTime", $this->namedtag["BrewTime"] - 1);

			foreach($this->getInventory()->getViewers() as $player){
				$windowId = $player->getWindowId($this->getInventory());
				if($windowId > 0){
					$pk = new ContainerSetDataPacket();
					$pk->windowid = $windowId;
					$pk->property = 0; //Brew
					$pk->value = $this->namedtag["BrewTime"];
					$player->dataPacket($pk);
				}
			}

			if($this->namedtag["BrewTime"] <= 0){
				$this->namedtag->BrewTime = new ShortTag("BrewTime", self::MAX_BREW_TIME);
				for($i = 1; $i <= 3; $i++){
					$potion = $this->inventory->getItem($i);
					$recipe = Server::getInstance()->getCraftingManager()->matchBrewingRecipe($ingredient, $potion);
					if($recipe != null and $potion->getId() !== Item::AIR){
						$this->inventory->setItem($i, $recipe->getResult());
					}
				}

				$ingredient->count--;
				if($ingredient->getCount() <= 0) $ingredient = Item::get(Item::AIR);
				$this->inventory->setIngredient($ingredient);
			}

			$ret = true;
		}else{
			$this->namedtag->BrewTime = new ShortTag("BrewTime", self::MAX_BREW_TIME);
			foreach($this->getInventory()->getViewers() as $player){
				$windowId = $player->getWindowId($this->getInventory());
				if($windowId > 0){
					$pk = new ContainerSetDataPacket();
					$pk->windowid = $windowId;
					$pk->property = 0; //Brew
					$pk->value = 0;
					$player->dataPacket($pk);
				}
			}
		}
		$this->lastUpdate = microtime(true);

		$this->timings->stopTiming();

		return $ret;
	}

	public function getSpawnCompound(){
		$nbt = new CompoundTag("", [
			new StringTag("id", Tile::BREWING_STAND),
			new IntTag("x", (int) $this->x),
			new IntTag("y", (int) $this->y),
			new IntTag("z", (int) $this->z),
			new ShortTag("BrewTime", self::MAX_BREW_TIME),
			$this->namedtag->Items,
		]);

		if($this->hasName()){
			$nbt->CustomName = $this->namedtag->CustomName;
		}
		return $nbt;
	}
}
