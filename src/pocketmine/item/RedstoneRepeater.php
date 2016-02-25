<?php

namespace pocketmine\item;

use pocketmine\block\Block;

class RedstoneRepeater extends Item{

	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::UNPOWERED_REPEATER);
		parent::__construct(self::REDSTONE_REPEATER, $meta, $count, "Repeater");
	}
}

