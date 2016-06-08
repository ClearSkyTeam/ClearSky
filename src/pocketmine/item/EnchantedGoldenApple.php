<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class EnchantedGoldenApple extends Food{
	
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::ENCHANTED_GOLDEN_APPLE, $meta, $count, "Enchanted Golden Apple");
	}

	public function getFoodRestore(){
		return 4;
	}

	public function getSaturationRestore(){
		return 9.6;
	}
	
	public function getEffects(){
		return [
			Effect::getEffect(Effect::REGENERATION)->setDuration(600)->setAmplifier(4),
			Effect::getEffect(Effect::ABSORPTION)->setDuration(2400),
			Effect::getEffect(Effect::DAMAGE_RESISTANCE)->setDuration(6000),
			Effect::getEffect(Effect::FIRE_RESISTANCE)->setDuration(6000),
		]
	}
}
