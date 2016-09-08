<?php

namespace pocketmine\item;

class IronLeggings extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::IRON_LEGGINGS, $meta, $count, "Iron Leggings");
	}

	public function getArmorTier(){
		return Armor::TIER_IRON;
	}

	public function getArmorType(){
		return Armor::TYPE_LEGGINGS;
	}

	public function getMaxDurability(){
		return 226;
	}

	public function getArmorValue(){
		return 5;
	}

	public function isLeggings(){
		return true;
	}
}