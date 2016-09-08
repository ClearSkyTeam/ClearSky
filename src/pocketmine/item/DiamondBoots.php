<?php

namespace pocketmine\item;

class DiamondBoots extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DIAMOND_BOOTS, $meta, $count, "Diamond Boots");
	}

	public function getArmorTier(){
		return Armor::TIER_DIAMOND;
	}

	public function getArmorType(){
		return Armor::TYPE_BOOTS;
	}

	public function getMaxDurability(){
		return 430;
	}

	public function getArmorValue(){
		return 3;
	}

	public function isBoots(){
		return true;
	}
}