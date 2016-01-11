<?php
namespace pocketmine\item;

use pocketmine\block\Block;

class WheatSeeds extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::WHEAT_BLOCK);
		parent::__construct(self::WHEAT_SEEDS, 0, $count, "Wheat Seeds");
	}
}