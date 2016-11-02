<?php

namespace pocketmine\item;

class ChainChestplate extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::CHAIN_CHESTPLATE, $meta, $count, "Chain Chestplate");
	}

	public function getArmorTier(){
		return Armor::TIER_CHAIN;
	}

	public function getArmorType(){
		return Armor::TYPE_CHESTPLATE;
	}

	public function getMaxDurability(){
		return 241;
	}

	public function getArmorValue(){
		return 5;
	}

	public function isChestplate(){
		return true;
	}
}