<?php
namespace pocketmine\item;

class RabbitStew extends Food{
	public $saturation = 10;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::RABBIT_STEW, 0, $count, "Rabbit Stew");
	}

	public function getMaxStackSize(){
		return 1;
	}

	public function getFoodRestore(){
		return 10;
	}

	public function getSaturationRestore(){
		return 7.2;//TODO: check if that value is correct
	}

	public function getResidue(){
		return Item::get(Item::BOWL);
	}
}