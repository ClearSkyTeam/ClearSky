<?php
namespace pocketmine\item;


class StoneShovel extends Tool{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::STONE_SHOVEL, $meta, $count, "Stone Shovel");
	}

	public function isShovel(){
		return Tool::TIER_STONE;
	}
}
