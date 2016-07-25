<?php
namespace pocketmine\item;

class Steak extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::STEAK, $meta, $count, "Steak");
	}

	public function getFoodRestore(){
		return 8;
	}

	public function getSaturationRestore(){
		return 12.8;
	}
}