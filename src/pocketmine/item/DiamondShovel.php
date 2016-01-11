<?php
namespace pocketmine\item;


class DiamondShovel extends Tool{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DIAMOND_SHOVEL, $meta, $count, "Diamond Shovel");
	}

	public function isShovel(){
		return Tool::TIER_DIAMOND;
	}
}
