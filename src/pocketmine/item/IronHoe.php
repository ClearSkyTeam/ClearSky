<?php
namespace pocketmine\item;


class IronHoe extends Tool{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::IRON_HOE, $meta, $count, "Iron Hoe");
	}

	public function isHoe(){
		return Tool::TIER_IRON;
	}
}