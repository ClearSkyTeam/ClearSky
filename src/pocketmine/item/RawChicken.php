<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class RawChicken extends Food{
	public $exp_smelt = 0.35;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::RAW_CHICKEN, $meta, $count, "Raw Chicken");
	}

	public function getFoodRestore(){
		return 2;
	}

	public function getSaturationRestore(){
		return 1.2;
	}

	public function getAdditionalEffects(){
		if(mt_rand(0, 9) < 3){
			return Effect::getEffect(Effect::HUNGER)->setDuration(600);
		}
	}
}