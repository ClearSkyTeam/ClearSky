<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class GoldenApple extends Food{
	public $saturation = 4;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLDEN_APPLE, $meta, $count, "Golden Apple");
	}

	public function getEffects(){
		return [
			[Effect::getEffect(Effect::ABSORPTION)->setDuration(120 * 20), 1],
			[Effect::getEffect(Effect::REGENERATION)->setDuration(2 * 20)->setAmplifier(1), 1]]:
		}
	}
}

