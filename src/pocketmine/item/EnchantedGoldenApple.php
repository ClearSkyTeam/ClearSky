<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class EnchantedGoldenApple extends Food{
	public $saturation = 4;
	
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::ENCHANTED_GOLDEN_APPLE, $meta, $count, "Enchanted Golden Apple");
	}
	
	public function getEffects(){
		return [
			[Effect::getEffect(Effect::ABSORPTION)->setDuration(120 * 20), 1],
			[Effect::getEffect(Effect::REGENERATION)->setDuration(30 * 20)->setAmplifier(4), 1],
			[Effect::getEffect(Effect::FIRE_RESISTANCE)->setDuration(5 * 60 * 20), 1],
			[Effect::getEffect(Effect::DAMAGE_RESISTANCE)->setDuration(5 * 60 * 20), 1]]
		];
	}
}
