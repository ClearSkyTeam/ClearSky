<?php
namespace pocketmine\item;


class Feather extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::FEATHER, 0, $count, "Feather");
	}

}