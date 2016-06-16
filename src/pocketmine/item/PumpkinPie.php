<?php
namespace pocketmine\item;

class PumpkinPie extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::PUMPKIN_PIE, $meta, $count, "Pumpkin Pie");
	}

	public function getFoodRestore(){
		return 8;
	}

	public function getSaturationRestore(){
		return 4.8;
	}
}

