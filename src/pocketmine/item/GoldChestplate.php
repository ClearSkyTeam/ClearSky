<?php

namespace pocketmine\item;

class GoldChestplate extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLD_CHESTPLATE, $meta, $count, "Gold Chestplate");
	}

	public function getArmorTier(){
		return Armor::TIER_GOLD;
	}

	public function getArmorType(){
		return Armor::TYPE_CHESTPLATE;
	}

	public function getMaxDurability(){
		return 113;
	}

	public function getArmorValue(){
		return 5;
	}

	public function isChestplate(){
		return true;
	}
}