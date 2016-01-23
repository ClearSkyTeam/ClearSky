<?php
namespace pocketmine\item;

class Clownfish extends Food{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::CLOWNFISH, $meta, $count, "Clownfish");
	}

	public function getSaturation(){
		return 1;
	}
}
