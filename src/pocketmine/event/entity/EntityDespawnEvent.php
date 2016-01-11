<?php
namespace pocketmine\event\entity;

use pocketmine\entity\Creature;
use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\entity\Item;
use pocketmine\entity\Projectile;
use pocketmine\entity\Vehicle;

/**
 * Called when a entity is despawned
 */
class EntityDespawnEvent extends EntityEvent{
	public static $handlerList = null;

	private $entityType;

	/**
	 * @param Entity $entity
	 */
	public function __construct(Entity $entity){
		$this->entity = $entity;
		$this->entityType = $entity::NETWORK_ID;
	}

	/**
	 * @return int
	 */
	public function getType(){
		return $this->entityType;
	}

	/**
	 * @return bool
	 */
	public function isCreature(){
		return $this->entity instanceof Creature;
	}

	/**
	 * @return bool
	 */
	public function isHuman(){
		return $this->entity instanceof Human;
	}

	/**
	 * @return bool
	 */
	public function isProjectile(){
		return $this->entity instanceof Projectile;
	}

	/**
	 * @return bool
	 */
	public function isVehicle(){
		return $this->entity instanceof Vehicle;
	}

	/**
	 * @return bool
	 */
	public function isItem(){
		return $this->entity instanceof Item;
	}

}