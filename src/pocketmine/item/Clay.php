<?php

namespace pocketmine\item;

class Clay extends Item{
	public $smeltingExp = 0.3;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::CLAY, $meta, $count, "Clay");
	}
}

