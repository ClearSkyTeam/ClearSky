<?php
namespace pocketmine\item;

class Sugar extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::SUGAR, $meta, $count, "Sugar");
	}

}

