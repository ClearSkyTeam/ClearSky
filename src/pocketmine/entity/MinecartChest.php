<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\item\Item as ItemItem;
use pocketmine\event\entity\EntityRegainHealthEvent;

class MinecartChest extends Minecart{

     const NETWORK_ID = 98;
     
    public function initEntity(){
        $this->setMaxHealth(4);
        $this->setHealth($this->getMaxHealth());
        parent::initEntity();
    }

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;
		$player->dataPacket($pk);
		parent::spawnTo($player);
	}

    public function getName(){
        return "Minecart Chest";
    }

    public function onUpdate($currentTick){
    	if($this->isAlive()){
    		$this->timings->startTiming();
    		$hasUpdate = false;
    		
    		if($this->isLinked() && $this->getlinkedTarget() !== null){
    			$hasUpdate = true;
				$newx = $this->getX() - $this->getlinkedTarget()->getX();
				$newy = $this->getY() - $this->getlinkedTarget()->getY();
				$newz = $this->getZ() - $this->getlinkedTarget()->getZ();
				$this->move($newx, $newy, $newz);
				$this->updateMovement();
			}
			if($this->getHealth() < $this->getMaxHealth()){
				$this->heal(0.1, new EntityRegainHealthEvent($this, 0.1, EntityRegainHealthEvent::CAUSE_CUSTOM));
				$hasUpdate = true;
    		}
    			
    		$this->timings->stopTiming();
    
    		return $hasUpdate;
    	}
    }

    public function getDrops(){
        return [ItemItem::get(ItemItem::MINECART, 0, 1),ItemItem::get(ItemItem::CHEST, 0, 1)];
    }
    
    //TODO: Open inventory, add inventory, drop inventory contents
}
