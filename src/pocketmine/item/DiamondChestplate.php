<?php

namespace pocketmine\item;

class DiamondChestplate extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DIAMOND_CHESTPLATE, $meta, $count, "Diamond Chestplate");
	}

	public function getArmorTier(){
		return Armor::TIER_DIAMOND;
	}

	public function getArmorType(){
		return Armor::TYPE_CHESTPLATE;
	}

	public function getMaxDurability(){
		return 529;
	}

	public function getArmorValue(){
		return 8;
	}

	public function isChestplate(){
		return true;
	}
}