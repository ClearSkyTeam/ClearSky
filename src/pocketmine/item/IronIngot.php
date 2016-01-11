<?php
namespace pocketmine\item;


class IronIngot extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::IRON_INGOT, 0, $count, "Iron Ingot");
	}

}