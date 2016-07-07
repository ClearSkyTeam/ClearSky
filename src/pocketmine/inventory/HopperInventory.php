<?php
namespace pocketmine\inventory;

use pocketmine\Player;
use pocketmine\inventory\ContainerInventory;
use pocketmine\inventory\InventoryType;
use pocketmine\tile\Hopper;

class HopperInventory extends ContainerInventory{
	public function __construct(Hopper $tile){
		parent::__construct($tile, InventoryType::get(InventoryType::HOPPER));
	}

	/**
	 * @return Hopper
	 */
	public function getHolder(){
		return $this->holder;
	}

	public function onClose(Player $who){
		parent::onClose($who);
	}
}