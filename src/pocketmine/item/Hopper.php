<?php

namespace pocketmine\item;

use pocketmine\block\Block;

class Hopper extends Item{

	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::HOPPER_BLOCK);
		parent::__construct(self::HOPPER, 0, $count, "Hopper");
	}
}

