<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\network\protocol\EntityEventPacket;
use pocketmine\item\Item as ItemItem;
use pocketmine\event\entity\EntityRegainHealthEvent;
use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Byte;

class Boat extends Vehicle{
	const NETWORK_ID = 90;
	
	public $height = 0.7;
	public $width = 1.6;
	public $gravity = 0.5;
	public $drag = 0.1;
	
	public function __construct(FullChunk $chunk, Compound $nbt){
		if(!isset($nbt->woodID)){
			$nbt->woodID = new Byte("woodID", 0);
		}
		parent::__construct($chunk, $nbt);
		$this->setDataProperty(self::DATA_BOAT_COLOR, self::DATA_TYPE_BYTE, $this->getWoodID());
	}
	
	public function initEntity(){
		$this->setMaxHealth(1);
		parent::initEntity();
	}
	
	public function getWoodID(){
		return $this->namedtag["woodID"];
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;
		$player->dataPacket($pk);
		parent::spawnTo($player);
	}

	public function attack($damage, EntityDamageEvent $source){
		parent::attack($damage, $source);

		if(!$source->isCancelled()){
			$pk = new EntityEventPacket();
			$pk->eid = $this->id;
			$pk->event = $this->getHealth() <= 0?EntityEventPacket::DEATH_ANIMATION:EntityEventPacket::HURT_ANIMATION;
			foreach($this->getLevel()->getPlayers() as $player){
				$player->dataPacket($pk);
			}
		}
	}
	
	public function onUpdate($currentTick){
		if($this->isAlive()){
			$this->timings->startTiming();
			$hasUpdate = false;
			
			if($this->isInsideOfWater()){
				$hasUpdate = true;
				$this->move(0,0.1,0);
				$this->updateMovement();
			}
			if($this->getHealth() < $this->getMaxHealth()){
				$this->heal(0.1, $source = EntityRegainHealthEvent::CAUSE_MAGIC);
				$hasUpdate = true;
			}
			
			$this->timings->stopTiming();

			return $hasUpdate;
		}
	}

	public function getDrops(){
		return [
			ItemItem::get(ItemItem::BOAT, $this->getWoodID(), 1)
		];
	}

	public function getSaveId(){
		$class = new \ReflectionClass(static::class);
		return $class->getShortName();
	}
}
