<?php
namespace pocketmine\item;

use pocketmine\block\Block;

class Redstone extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::REDSTONE_WIRE);
		parent::__construct(self::REDSTONE, 0, $count, "Redstone");
	}

}

