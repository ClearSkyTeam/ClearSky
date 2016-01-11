<?php
namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\entity\Projectile;
use pocketmine\event\Cancellable;
use pocketmine\item\Item;

class EntityLaunchFishingRodEvent extends EntityEvent implements Cancellable{
	public static $handlerList = null;

	/** @var Item */
	private $rod;
	/** @var Projectile */
	private $projectile;
	/** @var float */
	private $force;

	/**
	 * @param Living     $shooter
	 * @param Item       $rod
	 * @param Projectile $projectile
	 * @param float      $force
	 */
	public function __construct(Living $shooter, Item $rod, Projectile $projectile, $force){
		$this->entity = $shooter;
		$this->rod = $rod;
		$this->projectile = $projectile;
		$this->force = $force;
	}

	/**
	 * @return Living
	 */
	public function getEntity(){
		return $this->entity;
	}

	/**
	 * @return Item
	 */
	public function getBow(){
		return $this->rod;
	}

	/**
	 * @return Entity
	 */
	public function getProjectile(){
		return $this->projectile;
	}

	/**
	 * @param Entity $projectile
	 */
	public function setProjectile(Entity $projectile){
		if($projectile !== $this->projectile){
			if(count($this->projectile->getViewers()) === 0){
				$this->projectile->kill();
				$this->projectile->close();
			}
			$this->projectile = $projectile;
		}
	}

	/**
	 * @return float
	 */
	public function getForce(){
		return $this->force;
	}

	/**
	 * @param float $force
	 */
	public function setForce($force){
		$this->force = $force;
	}


}