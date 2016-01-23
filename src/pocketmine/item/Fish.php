<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class Fish extends Food{
	public $exp_smelt = 0.35; 


	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::RAW_FISH, $meta, $count, "Raw Fish");
	}

	public function getSaturation(){
		return 2;
	}
}
