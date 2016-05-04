<?php

namespace pocketmine\item;

class WoodenShovel extends Tool{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::WOODEN_SHOVEL, $meta, $count, "Wooden Shovel");
	}

	public function isShovel(){
		return Tool::TIER_WOODEN;
	}

	public function getMaxDurability(){
		return 60;
	}
}
