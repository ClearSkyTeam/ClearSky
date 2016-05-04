<?php

namespace pocketmine\item;

class IronHelmet extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::IRON_HELMET, $meta, $count, "Iron Helmet");
	}

	public function isArmor(){
		return true;
	}

	public function getMaxDurability(){
		return 166;
	}
}