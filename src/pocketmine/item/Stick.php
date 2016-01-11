<?php
namespace pocketmine\item;


class Stick extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::STICK, 0, $count, "Stick");
	}

}