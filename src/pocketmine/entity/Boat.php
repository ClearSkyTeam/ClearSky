<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\network\protocol\EntityEventPacket;
use pocketmine\item\Item as ItemItem;
use pocketmine\event\entity\EntityRegainHealthEvent;

class Boat extends Vehicle{
	const NETWORK_ID = 90;
	private $woodID = 1;

	public function initEntity(){
		$this->setMaxHealth(4);
		parent::initEntity();
				
		if(isset($this->namedtag->woodID)){
			$this->woodID = $this->namedtag["woodID"];
		}
		//for($i=10;$i<25;$i++){
		//$this->setDataProperty(20/*i*/, self::DATA_TYPE_BYTE, $this->getWoodID());
		//}
		$this->setDataProperty(self::DATA_BOAT_COLOR, self::DATA_TYPE_BYTE, $this->getWoodID());
	}
	
	public function getWoodID(){
		return $this->woodID;
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
	
	public function kill(){
		parent::kill();

		foreach($this->getDrops() as $item){
			$this->getLevel()->dropItem($this, $item);
		}
	}

	public function getDrops(){
		return [
			ItemItem::get(ItemItem::BOAT, 0, 1)
		];
	}

	public function getSaveId(){
		$class = new \ReflectionClass(static::class);
		return $class->getShortName();
	}
}
