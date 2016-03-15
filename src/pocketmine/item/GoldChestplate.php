<?php
namespace pocketmine\item;


class GoldChestplate extends Armor{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLD_CHESTPLATE, $meta, $count, "Gold Chestplate");
	}
	
	public function isArmor(){
		return true;
	}
}