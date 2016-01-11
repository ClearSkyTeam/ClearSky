<?php
namespace pocketmine\item;

use pocketmine\block\Block;

class OakDoor extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::OAK_DOOR_BLOCK);
		parent::__construct(self::OAK_DOOR, 0, $count, "Oak Door");
	}

	public function getMaxStackSize(){
		return 64;
	}
}
