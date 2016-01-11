<?php
namespace pocketmine\item;

class Arrow extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::ARROW, $meta, $count, "Arrow");
	}

}

