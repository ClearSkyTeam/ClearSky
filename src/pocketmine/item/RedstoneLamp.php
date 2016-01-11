<?php
namespace pocketmine\item;

use pocketmine\block\Block;

class RedstoneLamp extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::REDSTONE_LAMP);
		parent::__construct(self::REDSTONE_LAMP, 0, $count, "Redstone Lamp");
	}

	public function getMaxStackSize(){
		return 1;
	}
}
