<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class Spidereye extends Food{
	public $saturation = 2;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::SPIDER_EYE, $meta, $count, "Spider Eye");
	}

	public function getEffects(){
		return [Effect::getEffect(Effect::POISON)->setDuration(4 * 20) => 1];
	}
}