<?php
namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;

class EntityRegainHealthEvent extends EntityEvent implements Cancellable{
	public static $handlerList = null;

	const CAUSE_REGEN = 0;
	const CAUSE_EATING = 1;
	const CAUSE_MAGIC = 2;
	const CAUSE_CUSTOM = 3;
	const CAUSE_SATURATION = 4;

	private $amount;
	private $reason;


	/**
	 * @param Entity $entity
	 * @param float  $amount
	 * @param int    $regainReason
	 */
	public function __construct(Entity $entity, $amount, $regainReason){
		$this->entity = $entity;
		$this->amount = $amount;
		$this->reason = (int) $regainReason;
	}

	/**
	 * @return float
	 */
	public function getAmount(){
		return $this->amount;
	}

	/**
	 * @param float $amount
	 */
	public function setAmount($amount){
		$this->amount = $amount;
	}

	public function getRegainReason(){
		return $this->reason;
	}

}