<?php
namespace pocketmine\item;


class GoldAxe extends Tool{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLD_AXE, $meta, $count, "Gold Axe");
	}

	public function isAxe(){
		return Tool::TIER_GOLD;
	}
}