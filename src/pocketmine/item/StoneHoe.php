<?php

namespace pocketmine\item;

class StoneHoe extends Tool{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::STONE_HOE, $meta, $count, "Stone Hoe");
	}

	public function isHoe(){
		return Tool::TIER_STONE;
	}

	public function getMaxDurability(){
		return 132;
	}
}