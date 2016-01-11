<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;

class GoldenApple extends Food{
	const NORMAL = 0;
	const ENCHANTED = 1;
	public $saturation = 4;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLDEN_APPLE, $meta, $count, $this->getNameByMeta($meta));
	}

	public function getNameByMeta($meta){
		static $names = [self::NORMAL => "Golden Apple",self::ENCHANTED => "Enchanted Golden Apple",2 => "Unknown Apple"];
		return $names[$meta & 0x02];
	}

	public function getEffects(){
		return ($this->meta === self::NORMAL?[
					[Effect::getEffect(Effect::ABSORPTION)->setDuration(120 * 20), 1],
					[Effect::getEffect(Effect::REGENERATION)->setDuration(2 * 20)->setAmplifier(1), 1]]:
				($this->meta === self::ENCHANTED?[
					[Effect::getEffect(Effect::ABSORPTION)->setDuration(120 * 20), 1],
					[Effect::getEffect(Effect::REGENERATION)->setDuration(30 * 20)->setAmplifier(4), 1],
					[Effect::getEffect(Effect::FIRE_RESISTANCE)->setDuration(5 * 60 * 20), 1],
					[Effect::getEffect(Effect::DAMAGE_RESISTANCE)->setDuration(5 * 60 * 20), 1]]:
				[]));
	}
}

