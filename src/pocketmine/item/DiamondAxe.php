<?php

namespace pocketmine\item;

class DiamondAxe extends Tool{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DIAMOND_AXE, $meta, $count, "Diamond Axe");
	}

	public function isAxe(){
		return Tool::TIER_DIAMOND;
	}

	public function getMaxDurability(){
		return 1562;
	}
}