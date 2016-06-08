<?php
namespace pocketmine\item;

class Bread extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::BREAD, $meta, $count, "Bread");
	}

	public function getFoodRestore(){
		return 5;
	}

	public function getSaturationRestore(){
		return 6;
	}
}

