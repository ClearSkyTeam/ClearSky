<?php

namespace pocketmine\item;

class DiamondLeggings extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DIAMOND_LEGGINGS, $meta, $count, "Diamond Leggings");
	}

	public function getArmorTier(){
		return Armor::TIER_DIAMOND;
	}

	public function getArmorType(){
		return Armor::TYPE_LEGGINGS;
	}

	public function getMaxDurability(){
		return 496;
	}

	public function getArmorValue(){
		return 6;
	}

	public function isLeggings(){
		return true;
	}
}