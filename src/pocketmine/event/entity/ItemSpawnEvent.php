<?php
namespace pocketmine\event\entity;

use pocketmine\entity\Item;

class ItemSpawnEvent extends EntityEvent{
	public static $handlerList = null;

	/**
	 * @param Item $item
	 */
	public function __construct(Item $item){
		$this->entity = $item;

	}

	/**
	 * @return Item
	 */
	public function getEntity(){
		return $this->entity;
	}

}