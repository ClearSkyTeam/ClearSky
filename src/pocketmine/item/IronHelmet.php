<?php

namespace pocketmine\item;

class IronHelmet extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::IRON_HELMET, $meta, $count, "Iron Helmet");
	}

	public function getArmorTier(){
		return Armor::TIER_IRON;
	}

	public function getArmorType(){
		return Armor::TYPE_HELMET;
	}

	public function getMaxDurability(){
		return 166;
	}

	public function getArmorValue(){
		return 2;
	}

	public function isHelmet(){
		return true;
	}
}