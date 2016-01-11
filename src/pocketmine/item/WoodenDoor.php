<?php
namespace pocketmine\item;

use pocketmine\block\Block;

class WoodenDoor extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::WOODEN_DOOR_BLOCK);
		parent::__construct(self::WOODEN_DOOR, 0, $count, "Wooden Door");
	}

	public function getMaxStackSize(){
		return 1;
	}
}