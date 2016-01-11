<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class RottenFlesh extends Food{
	public $saturation = 4;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::ROTTEN_FLESH, 0, $count, "Rotten Flesh");
	}
	
	public function getEffects(){
		return [[Effect::getEffect(Effect::HUNGER)->setDuration(30 * 20),0.8]];
	}
}