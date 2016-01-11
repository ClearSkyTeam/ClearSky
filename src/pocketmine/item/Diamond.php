<?php
namespace pocketmine\item;


class Diamond extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DIAMOND, 0, $count, "Diamond");
	}

}