<?php

namespace pocketmine\item;

class ChainLeggings extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::CHAIN_LEGGINGS, $meta, $count, "Chain Leggings");
	}

	public function getArmorTier(){
		return Armor::TIER_CHAIN;
	}

	public function getArmorType(){
		return Armor::TYPE_LEGGINGS;
	}

	public function getMaxDurability(){
		return 226;
	}

	public function getArmorValue(){
		return 4;
	}

	public function isLeggings(){
		return true;
	}
}