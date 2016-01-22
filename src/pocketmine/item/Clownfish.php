<?php
namespace pocketmine\item;
use pocketmine\entity\Effect;
class Clownfish extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::RAW_FISH, $meta, $count, "Clownfish");
	}

	public function getSaturation(){
		return 1;
	}
}
