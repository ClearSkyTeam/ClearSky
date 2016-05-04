<?php

namespace pocketmine\item;

class DiamondSword extends Tool{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DIAMOND_SWORD, $meta, $count, "Diamond Sword");
	}

	public function isSword(){
		return Tool::TIER_DIAMOND;
	}

	public function getMaxDurability(){
		return 1562;
	}
}
