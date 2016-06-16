<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class SpiderEye extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::SPIDER_EYE, $meta, $count, "Spider Eye");
	}

	public function getFoodRestore(){
		return 2;
	}

	public function getSaturationRestore(){
		return 3.2;
	}

	public function getAdditionalEffects(){
		return [Effect::getEffect(Effect::POISON)->setDuration(80)];
	}
}