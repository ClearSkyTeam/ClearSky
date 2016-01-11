<?php
/**
 * Inventory related events
 */
namespace pocketmine\event\inventory;

use pocketmine\event\Event;
use pocketmine\inventory\Inventory;

abstract class InventoryEvent extends Event{

	/** @var Inventory */
	protected $inventory;

	public function __construct(Inventory $inventory){
		$this->inventory = $inventory;
	}

	/**
	 * @return Inventory
	 */
	public function getInventory(){
		return $this->inventory;
	}

	/**
	 * @return \pocketmine\entity\Human[]
	 */
	public function getViewers(){
		return $this->inventory->getViewers();
	}
}