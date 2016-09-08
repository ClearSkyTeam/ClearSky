<?php

namespace pocketmine\item;

class IronBoots extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::IRON_BOOTS, $meta, $count, "Iron Boots");
	}

	public function getArmorTier(){
		return Armor::TIER_IRON;
	}

	public function getArmorType(){
		return Armor::TYPE_BOOTS;
	}

	public function getMaxDurability(){
		return 196;
	}

	public function getArmorValue(){
		return 2;
	}

	public function isBoots(){
		return true;
	}
}