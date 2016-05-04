<?php

namespace pocketmine\item;

class WoodenHoe extends Tool{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::WOODEN_HOE, $meta, $count, "Wooden Hoe");
	}

	public function isHoe(){
		return Tool::TIER_WOODEN;
	}

	public function getMaxDurability(){
		return 60;
	}
}