<?php

namespace pocketmine\item;

class LeatherBoots extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::LEATHER_BOOTS, $meta, $count, "Leather Boots");
	}

	public function isArmor(){
		return true;
	}

	public function getMaxDurability(){
		return 66;
	}
}