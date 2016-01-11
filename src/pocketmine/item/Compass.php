<?php
namespace pocketmine\item;

class Compass extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::COMPASS, $meta, $count, "Compass");
	}

}

