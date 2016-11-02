<?php

namespace pocketmine\item;

class GoldHelmet extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLD_HELMET, $meta, $count, "Gold Helmet");
	}

	public function getArmorTier(){
		return Armor::TIER_GOLD;
	}

	public function getArmorType(){
		return Armor::TYPE_HELMET;
	}

	public function getMaxDurability(){
		return 78;
	}

	public function getArmorValue(){
		return 1;
	}

	public function isHelmet(){
		return true;
	}
}