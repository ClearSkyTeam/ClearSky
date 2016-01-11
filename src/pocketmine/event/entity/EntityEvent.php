<?php
/**
 * Entity related Events, like spawn, inventory, attack...
 */
namespace pocketmine\event\entity;

use pocketmine\event\Event;

abstract class EntityEvent extends Event{
	/** @var \pocketmine\entity\Entity */
	protected $entity;

	public function getEntity(){
		return $this->entity;
	}
}