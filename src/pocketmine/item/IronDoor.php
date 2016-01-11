<?php
namespace pocketmine\item;

use pocketmine\block\Block;

class IronDoor extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::IRON_DOOR_BLOCK);
		parent::__construct(self::IRON_DOOR, 0, $count, "Iron Door");
	}

	public function getMaxStackSize(){
		return 3;
	}
}