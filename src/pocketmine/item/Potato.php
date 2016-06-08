<?php
namespace pocketmine\item;

use pocketmine\block\Block;

class Potato extends Food{
	public $exp_smelt = 0.35;

	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::POTATO_BLOCK);
		parent::__construct(self::POTATO, 0, $count, "Potato");
	}

	public function getFoodRestore(){
		return 1;
	}

	public function getSaturationRestore(){
		return 0.6;
	}
}