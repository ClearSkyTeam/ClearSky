<?php
namespace pocketmine\item;


class DiamondLeggings extends Armor{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DIAMOND_LEGGINGS, $meta, $count, "Diamond Leggings");
	}
}