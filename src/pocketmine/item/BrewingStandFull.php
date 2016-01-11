<?php
namespace pocketmine\item;

use pocketmine\block\Block;

class BrewingStandFull extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::BREWING_STAND);
		parent::__construct(self::BREWING_STAND_FULL, 0, $count, "Brewing Stand");
	}

	public function getMaxStackSize(){
		return 1;
	}
}