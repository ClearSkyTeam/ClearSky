<?php

namespace pocketmine\item;

class IronPickaxe extends Tool{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::IRON_PICKAXE, $meta, $count, "Iron Pickaxe");
	}

	public function isPickaxe(){
		return Tool::TIER_IRON;
	}

	public function getMaxDurability(){
		return 251;
	}
}