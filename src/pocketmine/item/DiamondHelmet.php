<?php

namespace pocketmine\item;

class DiamondHelmet extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DIAMOND_HELMET, $meta, $count, "Diamond Helmet");
	}

	public function getArmorTier(){
		return Armor::TIER_DIAMOND;
	}

	public function getArmorType(){
		return Armor::TYPE_HELMET;
	}

	public function getMaxDurability(){
		return 364;
	}

	public function getArmorValue(){
		return 3;
	}

	public function isHelmet(){
		return true;
	}
}