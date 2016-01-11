<?php
namespace pocketmine\item;


class GoldHoe extends Tool{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLD_HOE, $meta, $count, "Gold Hoe");
	}

	public function isHoe(){
		return Tool::TIER_GOLD;
	}
}