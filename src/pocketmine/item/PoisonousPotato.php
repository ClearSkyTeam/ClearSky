<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class PoisonousPotato extends Food{
	public $saturation = 1;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::POISONOUS_POTATO, 0, $count, "Poisonous Potato");
	}

	public function getEffects(){
		return [Effect::getEffect(Effect::POISON)->setDuration(4 * 20) => 0.6];
	}
}