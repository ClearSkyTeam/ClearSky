<?php

namespace pocketmine\item;

class GoldPickaxe extends Tool{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLD_PICKAXE, $meta, $count, "Gold Pickaxe");
	}

	public function isPickaxe(){
		return Tool::TIER_GOLD;
	}

	public function getMaxDurability(){
		return 33;
	}
}
