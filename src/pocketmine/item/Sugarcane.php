<?php
namespace pocketmine\item;

use pocketmine\block\Block;

class Sugarcane extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::SUGARCANE_BLOCK);
		parent::__construct(self::SUGARCANE, 0, $count, "Sugar Cane");
	}
}