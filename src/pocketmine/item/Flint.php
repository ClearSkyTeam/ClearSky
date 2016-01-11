<?php
namespace pocketmine\item;

class Flint extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::FLINT, $meta, $count, "Flint");
	}

}

