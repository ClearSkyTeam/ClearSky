<?php
namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\Event;
use pocketmine\event\Cancellable;
use pocketmine\math\Vector3;

/**
 * @deprecated
 */
class EntityMoveEvent extends EntityEvent implements Cancellable{
	public static $handlerList = null;

	/** @var \pocketmine\math\Vector3 */
	private $pos;

	public function __construct(Entity $entity, Vector3 $pos){
		$this->entity = $entity;
		$this->pos = $pos;
	}

	public function getVector(){
		return $this->pos;
	}


}