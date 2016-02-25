<?php

namespace pocketmine\item;

use pocketmine\block\Block;

class RedstoneComparator extends Item{

	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::UNPOWERED_COMPARATOR);
		parent::__construct(self::COMPARATOR, $meta, $count, "Comparator");
	}
}

