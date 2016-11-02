<?php

namespace pocketmine\item;

class LeatherTunic extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::LEATHER_TUNIC, $meta, $count, "Leather Tunic");
	}

	public function getArmorTier(){
		return Armor::TIER_LEATHER;
	}

	public function getArmorType(){
		return Armor::TYPE_CHESTPLATE;
	}

	public function getMaxDurability(){
		return 81;
	}

	public function getArmorValue(){
		return 3;
	}

	public function isChestplate(){
		return true;
	}
}