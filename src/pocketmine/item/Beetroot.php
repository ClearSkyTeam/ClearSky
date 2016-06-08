<?php
namespace pocketmine\item;

class Beetroot extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::BEETROOT, $meta, $count, "Beetroot");
	}

	public function getFoodRestore(){
		return 1;
	}

	public function getSaturationRestore(){
		return 1.2;
	}
}