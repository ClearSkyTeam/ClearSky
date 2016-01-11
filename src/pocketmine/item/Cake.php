<?php
namespace pocketmine\item;

use pocketmine\block\Block;

class Cake extends Item{

	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(self::CAKE_BLOCK);
		parent::__construct(self::CAKE, 0, $count, "Cake");
	}

	public function getMaxStackSize(){
		return 1;
	}
}