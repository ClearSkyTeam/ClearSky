<?php

namespace pocketmine\item;

class FishingRod extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::FISHING_ROD, 0, $count, "Fishing Rod");
	}

	public function getMaxStackSize(){
		return 1;
	}

	public function canBeActivated(){
		return true;
	}

	public function getMaxDurability(){
		return 65;
	}
}