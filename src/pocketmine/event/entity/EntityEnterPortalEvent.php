<?php
namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;
use pocketmine\block\Block;

class EntityEnterPortalEvent extends EntityEvent implements Cancellable{
	public static $handlerList = null;

	public function __construct(Entity $entity, Block $portal){
		$this->entity = $entity;
		$this->portal = $portal;
	}
}