<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class Pufferfish extends Food{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::PUFFERFISH, $meta, $count, "Pufferfish");
	}

	public function getEffects(){
		return [
			[Effect::getEffect(Effect::NAUSEA)->setDuration(15 * 20)->setAmplifier(1), 1],
			[Effect::getEffect(Effect::HUNGER)->setDuration(15 * 20)->setAmplifier(2), 1],
			[Effect::getEffect(Effect::POISON)->setDuration(60 * 20)->setAmplifier(3), 1]
		];
	}
	
	public function getSaturation(){
		return 1;
	}
}
