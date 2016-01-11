<?php
namespace pocketmine\event\entity;

use pocketmine\block\Block;
use pocketmine\entity\Entity;

class EntityDamageByBlockEvent extends EntityDamageEvent{

	/** @var Block */
	private $damager;


	/**
	 * @param Block     $damager
	 * @param Entity    $entity
	 * @param int       $cause
	 * @param int|int[] $damage
	 */
	public function __construct(Block $damager, Entity $entity, $cause, $damage){
		$this->damager = $damager;
		parent::__construct($entity, $cause, $damage);
	}

	/**
	 * @return Block
	 */
	public function getDamager(){
		return $this->damager;
	}


}