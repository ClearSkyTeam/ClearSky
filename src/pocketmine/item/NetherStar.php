<?php
namespace pocketmine\item;

class NetherStar extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::NETHER_STAR, 0, $count, "Nether Star");
	}
}