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
        $this->setMaxHealth(1);
        $this->setHealth($this->getMaxHealth());
        parent::initEntity();
    }

    public function getName(){
        return "Minecart";
    }

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
            if($this->isLinked == false) {
                parent::onUpdate($currentTick);
            }
        }

        $this->timings->stopTiming();

        return $hasUpdate or !$this->onGround or abs($this->motionX) > 0.00001 or abs($this->motionY) > 0.00001 or abs($this->motionZ) > 0.00001;
    }

    public function spawnTo(Player $player){
        $pk = new AddEntityPacket();
        $pk->eid = $this->getId();
        $pk->type = Minecart::NETWORK_ID;
        $pk->x = $this->x;
        $pk->y = $this->y;
        $pk->z = $this->z;
        $pk->speedX = 0;
        $pk->speedY = 0;
        $pk->speedZ = 0;
        $pk->yaw = 0;
        $pk->pitch = 0;
        $pk->metadata = $this->dataProperties;
        $player->dataPacket($pk);

        parent::spawnTo($player);
    }

    public function attack($damage, EntityDamageEvent $source){
    	if($source instanceof EntityDamageByChildEntityEvent){
    		if($source instanceof ProjectileHitEvent && $source->getEntity() instanceof Arrow){
    			$this->setHealth(0);
    		}
    	}elseif($source instanceof EntityDamageByBlockEvent && $source->getDamager() instanceof Cactus){
    		$this->setHealth(0);
    	}
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

    public function kill(){
        parent::kill();

        foreach($this->getDrops() as $item){
            $this->getLevel()->dropItem($this, $item);
        }
    }

    public function getDrops(){
        return [ItemItem::get(ItemItem::MINECART, 0, 1)];
    }

    public function getSaveId(){
        $class = new \ReflectionClass(static::class);
        return $class->getShortName();
    }

    public function onPlayerAction(Player $player, $playerAction) {
        if($playerAction == 1) {
          //pressed move button
          $this->isLinked = true;
          $this->isMoving = true;
          $this->isFreeMoving = true;
          $this->setHealth($this->getMaxHealth());
          $player->linkEntity($this);
        } elseif(in_array($playerAction, array(2,3)) || $playerAction == PlayerActionPacket::ACTION_JUMP) {
          //touched
          $this->isLinked = false;
          $this->isMoving = false;
          $this->isFreeMoving = false;
          $this->setLinked(0, $player);
          $player->setLinked(0, $this);
          return $this;
        } elseif($playerAction == 157) {
            //playerMove
            $this->isFreeMoving = true;
            // try to get the bottom blockId, as Vector
            $position = $this->getPosition();
            $blockTemp = $this->level->getBlock($position);
            if(in_array($blockTemp->getId(),array(27, 28, 66, 126))) {
                //we are on rail
                $connected = $blockTemp->check($blockTemp);
                if(count($connected) >= 1){
                    foreach($connected as $newPosition) {
                        if($this->oldPosition != $newPosition || count($connected) == 1) {
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
    }

}
