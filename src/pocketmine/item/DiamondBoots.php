<?php

namespace pocketmine\item;

class DiamondBoots extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DIAMOND_BOOTS, $meta, $count, "Diamond Boots");
	}

	public function isArmor(){
		return true;
	}

	public function isBoots(){
		return true;
	}

	public function getMaxDurability(){
		return 430;
	}
}