<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class RawChicken extends Food{
	public $saturation = 2;
	public $smeltingExp = 0.35;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::RAW_CHICKEN, $meta, $count, "Raw Chicken");
	}

	public function getEffects(){
		return [[Effect::getEffect(Effect::HUNGER)->setDuration(30 * 20), 0.3]];
	}
}