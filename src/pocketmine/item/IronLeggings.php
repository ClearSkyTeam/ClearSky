<?php
namespace pocketmine\item;


class IronLeggings extends Armor{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::IRON_LEGGINGS, $meta, $count, "Iron Leggings");
	}
	
	public function isArmor(){
		return true;
	}
}