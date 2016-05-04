<?php

namespace pocketmine\item;

class DiamondPickaxe extends Tool{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DIAMOND_PICKAXE, $meta, $count, "Diamond Pickaxe");
	}

	public function isPickaxe(){
		return Tool::TIER_DIAMOND;
	}

	public function getMaxDurability(){
		return 1562;
	}
}
