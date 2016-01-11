<?php
namespace pocketmine\item;


class IronSword extends Tool{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::IRON_SWORD, $meta, $count, "Iron Sword");
	}

	public function isSword(){
		return Tool::TIER_IRON;
	}
}