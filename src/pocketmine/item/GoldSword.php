<?php
namespace pocketmine\item;


class GoldSword extends Tool{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLD_SWORD, $meta, $count, "Gold Sword");
	}

	public function isSword(){
		return Tool::TIER_GOLD;
	}
}
