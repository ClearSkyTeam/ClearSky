<?php
namespace pocketmine\item;

class RawPorkchop extends Food{
	public $exp_smelt = 0.35;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::RAW_PORKCHOP, $meta, $count, "Raw Porkchop");
	}

	public function getFoodRestore(){
		return 3;
	}

	public function getSaturationRestore(){
		return 1.8;
	}

}