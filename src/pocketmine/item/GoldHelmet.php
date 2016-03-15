<?php
namespace pocketmine\item;


class GoldHelmet extends Armor{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLD_HELMET, $meta, $count, "Gold Helmet");
	}
	
	public function isArmor(){
		return true;
	}
}