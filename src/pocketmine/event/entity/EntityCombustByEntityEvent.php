<?php
namespace pocketmine\event\entity;

use pocketmine\entity\Entity;

class EntityCombustByEntityEvent extends EntityCombustEvent{

	protected $combuster;

	/**
	 * @param Entity $combuster
	 * @param Entity $combustee
	 * @param int    $duration
	 */
	public function __construct(Entity $combuster, Entity $combustee, $duration){
		parent::__construct($combustee, $duration);
		$this->combuster = $combuster;
	}

	/**
	 * @return Entity
	 */
	public function getCombuster(){
		return $this->combuster;
	}

}