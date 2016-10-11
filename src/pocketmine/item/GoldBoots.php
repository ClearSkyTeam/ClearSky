<?php

namespace pocketmine\item;

class GoldBoots extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLD_BOOTS, $meta, $count, "Gold Boots");
	}

	public function getArmorTier(){
		return Armor::TIER_GOLD;
	}

	public function getArmorType(){
		return Armor::TYPE_BOOTS;
	}

	public function getMaxDurability(){
		return 92;
	}

	public function getArmorValue(){
		return 1;
	}

	public function isBoots(){
		return true;
	}
}