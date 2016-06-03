<?php
namespace pocketmine\entity;

use pocketmine\network\protocol\PlayerActionPacket;

use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\Player;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\network\protocol\EntityEventPacket;
use pocketmine\item\Item as ItemItem;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\block\Cactus;
use pocketmine\event\entity\EntityRegainHealthEvent;

class Minecart extends Vehicle{

     const NETWORK_ID = 84;

    public $height = 0.9;
    public $width = 1.1;

    public $drag = 0.1;
    public $gravity = 0.5;

    public $isMoving = false;
    public $moveSpeed = 0.4;

    public $isFreeMoving = false;
    public $isLinked = false;
    public $oldPosition = null;

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
        return "Minecart";
    }/*

    public function onUpdate($currentTick){
        if($this->closed !== false){
            return false;
        }

        $this->lastUpdate = $currentTick;

        $this->timings->startTiming();

        $hasUpdate = false;

        // if Minecart item is droped
        if($this->isLinked || $this->isAlive()){
            $this->motionY -= $this->gravity;

            if($this->checkObstruction($this->x, $this->y, $this->z)){
                $hasUpdate = true;
            }

            $this->move($this->motionX, $this->motionY, $this->motionZ);
            $this->updateMovement();

            $friction = 1 - $this->drag;

            if($this->onGround and (abs($this->motionX) > 0.00001 or abs($this->motionZ) > 0.00001)){
                $friction = $this->getLevel()->getBlock($this->temporalVector->setComponents((int) floor($this->x), (int) floor($this->y - 1), (int) floor($this->z) - 1))->getFrictionFactor() * $friction;
            }

            $this->motionX *= $friction;
            $this->motionY *= 1 - $this->drag;
            $this->motionZ *= $friction;

            if($this->onGround){
                $this->motionY *= -0.5;
            }

            if($this->isFreeMoving){
                $this->motionX = 0;
                $this->motionZ = 0;
                $this->isFreeMoving = false;
            }
        }else{
            if($this->isLinked == false){
                parent::onUpdate($currentTick);
            }
        }

        $this->timings->stopTiming();

        return $hasUpdate or !$this->onGround or abs($this->motionX) > 0.00001 or abs($this->motionY) > 0.00001 or abs($this->motionZ) > 0.00001;
    }*/
    


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
        return [ItemItem::get(ItemItem::MINECART, 0, 1)];
    }/*

    public function onPlayerAction(Player $player, $playerAction){
        if($playerAction == 1){
          //pressed move button
          $this->isLinked = true;
          $this->isMoving = true;
          $this->isFreeMoving = true;
          $this->setHealth($this->getMaxHealth());
          $player->linkEntity($this);
        } elseif(in_array($playerAction, array(2,3)) || $playerAction == PlayerActionPacket::ACTION_JUMP){
          //touched
          $this->isLinked = false;
          $this->isMoving = false;
          $this->isFreeMoving = false;
          $this->setLinked(0, $player);
          $player->setLinked(0, $this);
          return $this;
        } elseif($playerAction == 157){
            //playerMove
            $this->isFreeMoving = true;
            // try to get the bottom blockId, as Vector
            $position = $this->getPosition();
            $blockTemp = $this->level->getBlock($position);
            if(in_array($blockTemp->getId(),array(27, 28, 66, 126))){
                //we are on rail
                $connected = $blockTemp->check($blockTemp);
                if(count($connected) >= 1){
                    foreach($connected as $newPosition){
                        if($this->oldPosition != $newPosition || count($connected) == 1){
                            $this->oldPosition = $position->add(0,0,0);
                            $this->setPosition($newPosition);
                            return $newPosition;
                        }
                    }
                }
            }
            return false;

        }

        return true;
    }*/

}
