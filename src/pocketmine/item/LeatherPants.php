<?php

namespace pocketmine\item;

class LeatherPants extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::LEATHER_PANTS, $meta, $count, "Leather Pants");
	}

	public function getArmorTier(){
		return Armor::TIER_LEATHER;
	}

	public function getArmorType(){
		return Armor::TYPE_LEGGINGS;
	}

	public function getMaxDurability(){
		return 76;
	}

	public function getArmorValue(){
		return 2;
	}

	public function isLeggings(){
		return true;
	}
}