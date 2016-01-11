<?php
namespace pocketmine\item;

class GoldNugget extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLD_NUGGET, $meta, $count, "Gold Nugget");
	}

}

