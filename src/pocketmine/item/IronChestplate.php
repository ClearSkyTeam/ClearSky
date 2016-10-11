<?php

namespace pocketmine\item;

class IronChestplate extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::IRON_CHESTPLATE, $meta, $count, "Iron Chestplate");
	}

	public function getArmorTier(){
		return Armor::TIER_IRON;
	}

	public function getArmorType(){
		return Armor::TYPE_CHESTPLATE;
	}

	public function getMaxDurability(){
		return 241;
	}

	public function getArmorValue(){
		return 6;
	}

	public function isChestplate(){
		return true;
	}
}