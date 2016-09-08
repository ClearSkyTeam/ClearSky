<?php

namespace pocketmine\item;

class LeatherBoots extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::LEATHER_BOOTS, $meta, $count, "Leather Boots");
	}

	public function getArmorTier(){
		return Armor::TIER_LEATHER;
	}

	public function getArmorType(){
		return Armor::TYPE_BOOTS;
	}

	public function getMaxDurability(){
		return 66;
	}

	public function getArmorValue(){
		return 1;
	}

	public function isBoots(){
		return true;
	}
}