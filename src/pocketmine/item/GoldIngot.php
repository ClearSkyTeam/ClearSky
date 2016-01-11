<?php
namespace pocketmine\item;


class GoldIngot extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLD_INGOT, 0, $count, "Gold Ingot");
	}

}