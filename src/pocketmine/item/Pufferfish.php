<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class Pufferfish extends Food{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::PUFFERFISH, $meta, $count, "Pufferfish");
	}

	public function getSaturation(){
		return 1;
	}
}
