<?php
namespace pocketmine\item;

class Dye extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DYE, $meta, $count, "Dye");
	}

}

