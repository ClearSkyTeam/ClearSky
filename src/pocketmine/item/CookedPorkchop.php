<?php
namespace pocketmine\item;

class CookedPorkchop extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::COOKED_PORKCHOP, $meta, $count, "Cooked Porkchop");
	}

	public function getFoodRestore(){
		return 8;
	}

	public function getSaturationRestore(){
		return 12.8;
	}
}

