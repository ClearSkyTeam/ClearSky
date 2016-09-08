<?php

namespace pocketmine\item;

class LeatherCap extends Armor{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::LEATHER_CAP, $meta, $count, "Leather Cap");
	}

	public function isArmor(){
		return true;
	}

	public function isHelmet(){
		return true;
	}

	public function getMaxDurability(){
		return 56;
	}
}