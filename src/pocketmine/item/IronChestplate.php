<?php

namespace pocketmine\item;

class IronChestplate extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::IRON_CHESTPLATE, $meta, $count, "Iron Chestplate");
	}

	public function isArmor(){
		return true;
	}

	public function getMaxDurability(){
		return 241;
	}
}