<?php

namespace pocketmine\item;

class IronBoots extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::IRON_BOOTS, $meta, $count, "Iron Boots");
	}

	public function isArmor(){
		return true;
	}

	public function isBoots(){
		return true;
	}

	public function getMaxDurability(){
		return 196;
	}
}