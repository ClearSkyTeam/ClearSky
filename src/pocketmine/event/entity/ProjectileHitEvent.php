<?php
namespace pocketmine\event\entity;

use pocketmine\entity\Projectile;

class ProjectileHitEvent extends EntityEvent{
	public static $handlerList = null;

	/**
	 * @param Projectile $entity
	 */
	public function __construct(Projectile $entity){
		$this->entity = $entity;

	}

	/**
	 * @return Projectile
	 */
	public function getEntity(){
		return $this->entity;
	}

}