<?php
namespace pocketmine\event\entity;

use pocketmine\entity\Entity;

class EntityDamageByChildEntityEvent extends EntityDamageByEntityEvent{

	/** @var Entity */
	private $childEntity;


	/**
	 * @param Entity    $damager
	 * @param Entity    $childEntity
	 * @param Entity    $entity
	 * @param int       $cause
	 * @param int|int[] $damage
	 */
	public function __construct(Entity $damager, Entity $childEntity, Entity $entity, $cause, $damage){
		$this->childEntity = $childEntity;
		parent::__construct($damager, $entity, $cause, $damage);
	}

	/**
	 * @return Entity
	 */
	public function getChild(){
		return $this->childEntity;
	}


}