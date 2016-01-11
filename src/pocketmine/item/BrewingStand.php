<?php
namespace pocketmine\item;

use pocketmine\block\Block;

class BrewingStand extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::BREWING_STAND_BLOCK);
		parent::__construct(self::BREWING_STAND, 0, $count, "Brewing Stand");
	}

	public function getMaxStackSize(){
		return 64;
	}
}