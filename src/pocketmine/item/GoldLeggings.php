<?php

namespace pocketmine\item;

class GoldLeggings extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLD_LEGGINGS, $meta, $count, "Gold Leggings");
	}

	public function getArmorTier(){
		return Armor::TIER_GOLD;
	}

	public function getArmorType(){
		return Armor::TYPE_LEGGINGS;
	}

	public function getMaxDurability(){
		return 106;
	}

	public function getArmorValue(){
		return 3;
	}

	public function isLeggings(){
		return true;
	}
}