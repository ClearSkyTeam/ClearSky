<?php
namespace pocketmine\item;


class DiamondChestplate extends Armor{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DIAMOND_CHESTPLATE, $meta, $count, "Diamond Chestplate");
	}
}