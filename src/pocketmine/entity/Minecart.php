<?php
namespace pocketmine\entity;

use pocketmine\network\protocol\PlayerActionPacket;
use pocketmine\Player;
<<<<<<< HEAD
use pocketmine\item\Item as ItemItem;
use pocketmine\event\entity\EntityRegainHealthEvent;
=======
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\network\protocol\EntityEventPacket;
use pocketmine\math\Math;
use pocketmine\math\Vector3;
>>>>>>> 591d862... Add support for minecart to follow the rails and related pull request comments fixes.

class Minecart extends Vehicle{

<<<<<<< HEAD
     const NETWORK_ID = 84;

    public $height = 0.9;
    public $width = 1.1;
=======
	const TYPE_NORMAL = 1;
	const TYPE_CHEST = 2;
	const TYPE_HOPPER = 3;
	const TYPE_TNT = 4;
	
	const STATE_INITIAL = 0;
	const STATE_ON_RAIL = 1;
	const STATE_OFF_RAIL = 2;

	public $height = 0.7;
	public $width = 0.98;
>>>>>>> 591d862... Add support for minecart to follow the rails and related pull request comments fixes.

    public $drag = 0.1;
    public $gravity = 0.5;

<<<<<<< HEAD
    public $isMoving = false;
    public $moveSpeed = 0.4;

    public $isFreeMoving = false;
    public $isLinked = false;
    public $oldPosition = null;
=======
	public $isMoving = false;
	public $moveSpeed = 0.4;
	
	private $onRail = Minecart::STATE_INITIAL;
	private $direction = -1;
	private $moveVector = [];
	private $requestedPosition = null;
	
	public function initEntity(){
		$this->setMaxHealth(1);
		$this->setHealth($this->getMaxHealth());
		$this->moveVector[Entity::NORTH] = new Vector3(-1, 0, 0);
		$this->moveVector[Entity::SOUTH] = new Vector3(1, 0, 0);
		$this->moveVector[Entity::EAST] = new Vector3(0, 0, -1);
		$this->moveVector[Entity::WEST] = new Vector3(0, 0, 1);
		$this->moveVector[Entity::NORTH] = new Vector3(-1, 0, 0);
		$this->moveVector[Entity::SOUTH] = new Vector3(1, 0, 0);
		$this->moveVector[Entity::EAST] = new Vector3(0, 0, -1);
		$this->moveVector[Entity::WEST] = new Vector3(0, 0, 1);
		parent::initEntity();
	}
>>>>>>> 591d862... Add support for minecart to follow the rails and related pull request comments fixes.

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

<<<<<<< HEAD
    public function getName(){
        return "Minecart";
    }/*

    public function onUpdate($currentTick){
        if($this->closed !== false){
            return false;
        }

        $this->lastUpdate = $currentTick;

        $this->timings->startTiming();
=======
	public function onUpdate($currentTick){
		if($this->closed !== false){
			return false;
		}
		
		$tickDiff = $currentTick - $this->lastUpdate;
		if($tickDiff <= 1){
			return false;
		}

		$this->lastUpdate = $currentTick;

		$this->timings->startTiming();

		$hasUpdate = false;
		//parent::onUpdate($currentTick);

		if($this->isAlive()){
			$movingType = $this->getLevel()->getServer()->minecartMovingType;
			if($movingType == -1) return false;
			elseif($movingType == 0){
				$p = $this->getLinkedEntity();
				if($p instanceof Player){
					$this->motionX = -sin($p->getYaw() / 180 * M_PI);
					$this->motionZ = cos($p->getYaw() / 180 * M_PI);
				}
				$target = $this->getLevel()->getBlock($this->add($this->motionX, 0, $this->motionZ)->round());
				$target2 = $this->getLevel()->getBlock($this->add($this->motionX, 0, $this->motionZ)->floor());
				if($target->getId() != ItemItem::AIR or $target2->getId() != ItemItem::AIR) $this->motionY = $this->gravity * 3;
				else $this->motionY -= $this->gravity;

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
			}elseif($movingType == 1){
				$p = $this->getLinkedEntity();
				if($p instanceof Player){
					if ($this->state == Minecart::STATE_INITIAL) {
						$this->checkIfOnRail();
					}
					if ($this->state == Minecart::STATE_ON_RAIL) {
						$hasUpdate = $this->forwardOnRail($p);
						$this->updateMovement();
					}
				}
			}
		}
		$this->timings->stopTiming ();
		
		return $hasUpdate or ! $this->onGround or abs ( $this->motionX ) > 0.00001 or abs ( $this->motionY ) > 0.00001 or abs ( $this->motionZ ) > 0.00001;
	}
	
	
	/**
	 * Check if minecart is currently on a rail and if so center the cart.
	 */
	private function checkIfOnRail() {
		$rail = $this->level->getBlock($this->temporalVector->setComponents($this->x, $this->y - 1, $this->z));
		if ($rail != null && in_array($rail->getId(), [Block::RAIL, Block::ACTIVATOR_RAIL, Block::DETECTOR_RAIL, Block::POWERED_RAIL])) {
			$rail = $rail->floor()->add(.5, 0, .5); 
			$this->setPosition($rail);    // Move minecart to center of rail
			$this->state = Minecart::STATE_ON_RAIL;
		} else {
			$this->state = Minecart::STATE_OFF_RAIL;
		}
	}
	
	/**
	 * Attempt to move forward on rail given the direction the cart is already moving, or if not moving based
	 * on the direction the player is looking.
	 * @param Player $player Player riding the minecart.
	 * @return boolean True if minecart moved, false otherwise.
	 */
	private function forwardOnRail(Player $player) {
		if ($this->direction == -1) {
			$candidateDirection = $player->getDirection();			
		} else {
			$candidateDirection = $this->direction;
		}
		$block = $this->getLevel()->getBlock($this);
		$railType = $block->getDamage ();
		$nextDirection = $this->getDirectionToMove($railType, $candidateDirection);
		if ($nextDirection != -1) {
			$this->direction = $nextDirection;
			return $this->moveIfRail();
		} else {
			$this->direction = -1;  // Was not able to determine direction to move, so wait for player to look in valid direction
		}
		return false;
	}
	
	/**
	 * Determine the direction the minecart should move based on the candidate direction (current direction
	 * minecart is moving, or the direction the player is looking) and the type of rail that the minecart is
	 * on.
	 * @param RailType $railType Type of rail the minecart is on. 
	 * @param Direction $candidateDirection Direction minecart already moving, or direction player looking.
	 * @return Direction The direction the minecart should move.
	 */
	private function getDirectionToMove($railType, $candidateDirection) {
		switch ($railType) {
			case Rail::STRAIGHT_NORTH_SOUTH :
				switch ($candidateDirection) {
					case Entity::NORTH :
					case Entity::SOUTH :
						return $candidateDirection;
				}
				break;
			case Rail::STRAIGHT_EAST_WEST :
				switch ($candidateDirection) {
					case Entity::WEST :
					case Entity::EAST :
						return $candidateDirection;
				}
				break;
			case Rail::SLOPED_ASCENDING_EAST :
				switch ($candidateDirection) {
					case Entity::WEST :
					case Entity::EAST :
						return $candidateDirection;
				}
				break;
			case Rail::SLOPED_ASCENDING_WEST :
				switch ($candidateDirection) {
					case Entity::WEST :
					case Entity::EAST :
						return $candidateDirection;
				}
				break;
			case Rail::SLOPED_ASCENDING_NORTH :
				switch ($candidateDirection) {
					case Entity::NORTH :
					case Entity::SOUTH :
						return $candidateDirection;
				}
				break;
			case Rail::SLOPED_ASCENDING_SOUTH :
				switch ($candidateDirection) {
					case Entity::NORTH :
					case Entity::SOUTH :
						return $candidateDirection;
				}
				break;
			case Rail::CURVED_SOUTH_EAST :
				switch ($candidateDirection) {
					case Entity::SOUTH :
					case Entity::EAST :
						return $candidateDirection;
					case Entity::NORTH :
						return $this->checkForTurn($candidateDirection, Entity::EAST);
					case Entity::WEST :
						return $this->checkForTurn($candidateDirection, Entity::SOUTH);
				}
				break;
			case Rail::CURVED_SOUTH_WEST :
				switch ($candidateDirection) {
					case Entity::SOUTH :
					case Entity::WEST :
						return $candidateDirection;
					case Entity::NORTH :
						return $this->checkForTurn($candidateDirection, Entity::WEST);
					case Entity::EAST :
						return $this->checkForTurn($candidateDirection, Entity::SOUTH);
				}
				break;
			case Rail::CURVED_NORTH_WEST :
				switch ($candidateDirection) {
					case Entity::NORTH :
					case Entity::WEST :
						return $candidateDirection;
					case Entity::SOUTH :
						return $this->checkForTurn($candidateDirection, Entity::WEST);
					case Entity::EAST :
						return $this->checkForTurn($candidateDirection, Entity::NORTH);

				}
				break;
			case Rail::CURVED_NORTH_EAST :
				switch ($candidateDirection) {
					case Entity::NORTH :
					case Entity::EAST :
						return $candidateDirection;
					case Entity::SOUTH :
						return $this->checkForTurn($candidateDirection, Entity::EAST);
					case Entity::WEST :
						return $this->checkForTurn($candidateDirection, Entity::NORTH);
				}
				break;
		}
		return -1;
	}
	
	/**
	 * Need to alter direction on curves halfway through the turn and reset the minecart to be in the middle of
	 * the rail again so as not to collide with nearby blocks.
	 * @param Direction $currentDirection Direction minecart currently moving
	 * @param Direction $newDirection Direction minecart should turn once has hit the halfway point.
	 * @return Direction Either the current direction or the new direction depending on haw far across the rail the 
	 * minecart is.
	 */
	private function checkForTurn($currentDirection, $newDirection) {
		switch($currentDirection) {
			case Entity::NORTH:
				$diff = $this->x - $this->getFloorX();
				if ($diff != 0 && $diff <= .5) {
					$this->x = $this->getFloorX() + .5;
					return $newDirection;
				}
				break;
			case Entity::SOUTH:
				$diff = $this->x - $this->getFloorX();
				if ($diff != 0 && $diff >= .5) {
					$this->x = $this->getFloorX() + .5;
					return $newDirection;
				}
				break;
			case Entity::EAST:
				$diff = $this->z - $this->getFloorZ();
				if ($diff != 0 && $diff <= .5) {
					$this->z = $this->getFloorZ() + .5;
					return $newDirection;
				}
				break;
			case Entity::WEST:
				$diff = $this->z - $this->getFloorZ();
				if ($diff != 0 && $diff >= .5) {
					$this->z = $this->getFloorZ() + .5;
					return $newDirection;
				}
				break;
		}
		return $currentDirection; // Keep going noth until half way.
	}
	
	/**
	 * Move the minecart as long as it will still be moving on to another piece of rail.
	 * @return boolean True if the minecart moved.
	 */
	private function moveIfRail() {
		$nextMoveVector = $this->moveVector[$this->direction];
		$nextMoveVector = $nextMoveVector->multiply($this->moveSpeed);
		$newVector = $this->add($nextMoveVector->x, $nextMoveVector->y, $nextMoveVector->z);
		$possibleRail = $this->level->getBlock($newVector);
		if(in_array($possibleRail->getId(), [Block::RAIL, Block::ACTIVATOR_RAIL, Block::DETECTOR_RAIL, Block::POWERED_RAIL])) {
			$this->moveUsingVector($newVector);
			return true;
		} else {
			$newVector = $newVector->add(0, -1, 0);
			// Rail could be one block down since sloping down
			$possibleRail = $this->level->getBlock($newVector);
			$damage = $possibleRail->getDamage();
			if(in_array($possibleRail->getId(), [Block::RAIL, Block::ACTIVATOR_RAIL, Block::DETECTOR_RAIL, Block::POWERED_RAIL])) {
				$this->moveUsingVector($newVector);
				return true;
			} else {
				$newVector = $newVector->add(0, 2, 0);
				// Rail could be one block up since sloping up
				$possibleRail = $this->level->getBlock($newVector);
				if(in_array($possibleRail->getId(), [Block::RAIL, Block::ACTIVATOR_RAIL, Block::DETECTOR_RAIL, Block::POWERED_RAIL])) {
					$this->moveUsingVector($newVector);
					return true;
				} else {
					return false;
					// TODO Need a way to update state to say cart is stuck?
				}
			}
		}
	}
	
	/**
	 * Invoke the normal move code, but first need to convert the desired position vector into the
	 * delta values from the current position.
	 * @param Vector3 $desiredPosition
	 */
	private function moveUsingVector(Vector3 $desiredPosition) {
		$dx = $desiredPosition->x - $this->x;
		$dy = $desiredPosition->y - $this->y;
		$dz = $desiredPosition->z - $this->z;
		if ($this->requestedPosition != null && $desiredPosition->x == $this->requestedPosition->x && $desiredPosition->y == $this->requestedPosition->y &&
			$desiredPosition->z == $this->requestedPosition->z) {
				// TODO Why doesn't just setting $dy to $dy + 1 work?
				$upPosition = $this->add(0, 1, 0); // tried $dy = $dy + 1 but didn't work
				$this->setPosition($upPosition);
			}
			$this->requestedPosition = $this->add($dx, $dy, $dz);
			$this->move($dx, $dy, $dz);
	}

>>>>>>> 591d862... Add support for minecart to follow the rails and related pull request comments fixes.

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
