<?php
namespace pocketmine\item;

class CookedFish extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::COOKED_FISH, $meta, $count, "Cooked Fish");
	}

	public function getSaturation(){
		return 5;
	}
}
