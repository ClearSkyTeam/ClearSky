<?php
namespace pocketmine\inventory;

use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\inventory\ContainerInventory;
use pocketmine\inventory\FakeBlockMenu;
use pocketmine\inventory\InventoryType;

class DropperInventory extends ContainerInventory{
	public function __construct(Position $pos){
		parent::__construct(new FakeBlockMenu($this, $pos), InventoryType::get(InventoryType::DROPPER));
	}

	/**
	 * @return FakeBlockMenu
	 */
	public function getHolder(){
		return $this->holder;
	}

	public function onClose(Player $who){
		parent::onClose($who);
	}
}