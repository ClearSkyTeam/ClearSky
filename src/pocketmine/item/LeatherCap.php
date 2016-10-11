<?php

namespace pocketmine\item;

class LeatherCap extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::LEATHER_CAP, $meta, $count, "Leather Cap");
	}

	public function getArmorTier(){
		return Armor::TIER_LEATHER;
	}

	public function getArmorType(){
		return Armor::TYPE_HELMET;
	}

	public function getMaxDurability(){
		return 56;
	}

	public function getArmorValue(){
		return 1;
	}

	public function isHelmet(){
		return true;
	}
}