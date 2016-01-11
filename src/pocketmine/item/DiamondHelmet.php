<?php
namespace pocketmine\item;


class DiamondHelmet extends Armor{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DIAMOND_HELMET, $meta, $count, "Diamond Helmet");
	}
}