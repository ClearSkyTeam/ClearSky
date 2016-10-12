<?php

namespace pocketmine\item;

class FilledMap extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::FILLED_MAP, $meta, $count, "Filled Map");
	}
}