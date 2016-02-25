<?php

namespace pocketmine\item;

use pocketmine\block\Block;

class Cauldron extends Item{

	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::CAULDRON_BLOCK);
		parent::__construct(self::CAULDRON, $meta, $count, "Cauldron");
	}
}

