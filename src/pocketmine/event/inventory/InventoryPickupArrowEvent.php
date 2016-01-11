<?php
namespace pocketmine\event\inventory;

use pocketmine\entity\Arrow;
use pocketmine\event\Cancellable;
use pocketmine\inventory\Inventory;

class InventoryPickupArrowEvent extends InventoryEvent implements Cancellable{
	public static $handlerList = null;

	/** @var Arrow */
	private $arrow;

	/**
	 * @param Inventory $inventory
	 * @param Arrow     $arrow
	 */
	public function __construct(Inventory $inventory, Arrow $arrow){
		$this->arrow = $arrow;
		parent::__construct($inventory);
	}

	/**
	 * @return Arrow
	 */
	public function getArrow(){
		return $this->arrow;
	}

}