<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class RottenFlesh extends Food{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::ROTTEN_FLESH, 0, $count, "Rotten Flesh");
	}
	
	public function getAdditionalEffects(){
		if(mt_rand(0, 10) < 8){
			return Effect::getEffect(Effect::HUNGER)->setDuration(30 * 20);
		}
	}

	public function getFoodRestore(){
		return 4;
	}

	public function getSaturationRestore(){
		return 1.8;//TODO: check value
	}
}