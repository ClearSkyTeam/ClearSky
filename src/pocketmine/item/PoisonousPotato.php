<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class PoisonousPotato extends Food{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::POISONOUS_POTATO, 0, $count, "Poisonous Potato");
	}
	
	public function getFoodRestore(){
		return 1;
	}

	public function getSaturationRestore(){
		return 1.2;//TODO: check value
	}

	public function getAdditionalEffects(){
		if(mt_rand(0, 10) < 6){
			Effect::getEffect(Effect::POISON)->setDuration(4 * 20);
		}
	}
}