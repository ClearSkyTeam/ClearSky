<?php
namespace pocketmine\entity;

use pocketmine\block\Block;
use pocketmine\block\Rail;
use pocketmine\item\Item as ItemItem;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\Player;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\network\protocol\EntityEventPacket;
use pocketmine\math\Math;
use pocketmine\math\Vector3;

class Minecart extends Vehicle{

	const NETWORK_ID = 84;
	
	const STATE_INITIAL = 0;
	const STATE_ON_RAIL = 1;
	const STATE_OFF_RAIL = 2;

	public $height = 0.7;
	public $width = 0.98;

	public $drag = 0.1;
	public $gravity = 0.5;

	public $isMoving = false;
	public $moveSpeed = 0.4;
	public $isLinked = false;
	
	private $state = Minecart::STATE_INITIAL;
	private $direction = -1;
	private $moveVector = [];
	private $requestedPosition = null;
	
	public function initEntity(){
		$this->setMaxHealth(4);
		$this->setHealth($this->getMaxHealth());
		$this->moveVector[Entity::NORTH] = new Vector3(-1, 0, 0);
		$this->moveVector[Entity::SOUTH] = new Vector3(1, 0, 0);
		$this->moveVector[Entity::EAST] = new Vector3(0, 0, -1);
		$this->moveVector[Entity::WEST] = new Vector3(0, 0, 1);
		parent::initEntity();
	}

	public function getName(){
		return "Minecart";
	}
	
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
			$movingType = $this->getLevel()->getServer()->getProperty("minecart-moving-type", 1);
			if($movingType == -1) return false;
			elseif($movingType == 0){
				$p = $this->getlinkedTarget();
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
				$p = $this->getlinkedTarget();
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
		$this->requestedPosition = $this->add($dx, $dy, $dz);//$dy = delta y, here its called correctly
		$this->move($dx, $dy, $dz);//but here you move it to for example 0, 1, 0
	}

	/**
	* @return Rail
	*/
	public function getNearestRail(){
		$minX = Math::floorFloat($this->boundingBox->minX);
		$minY = Math::floorFloat($this->boundingBox->minY);
		$minZ = Math::floorFloat($this->boundingBox->minZ);
		$maxX = Math::ceilFloat($this->boundingBox->maxX);
		$maxY = Math::ceilFloat($this->boundingBox->maxY);
		$maxZ = Math::ceilFloat($this->boundingBox->maxZ);

		$rails = [];

		for($z = $minZ; $z <= $maxZ; ++$z){
			for($x = $minX; $x <= $maxX; ++$x){
				for($y = $minY; $y <= $maxY; ++$y){
					$block = $this->level->getBlock($this->temporalVector->setComponents($x, $y, $z));
					if(in_array($block->getId(), [Block::RAIL, Block::ACTIVATOR_RAIL, Block::DETECTOR_RAIL, Block::POWERED_RAIL])) $rails[] = $block;
				}
			}
		}

		$minDistance = PHP_INT_MAX;
		$nearestRail = null;
		foreach($rails as $rail){
			$dis = $this->distance($rail);
			if($dis < $minDistance){
				$nearestRail = $rail;
				$minDistance = $dis;
			}
		}
		return $nearestRail;
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;
		$player->dataPacket($pk);

		Entity::spawnTo($player);
	}

	public function getDrops(){
		return [ItemItem::get(ItemItem::MINECART, 0, 1)];
	}
}
