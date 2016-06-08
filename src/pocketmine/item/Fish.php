<?php

namespace pocketmine\item;

use pocketmine\entity\Effect;

class Fish extends Food{
	const FISH_FISH = 0;
	const FISH_SALMON = 1;
	const FISH_CLOWNFISH = 2;
	const FISH_PUFFERFISH = 3;

	public function __construct($meta = 0, $count = 1){
		$name = "Raw Fish";
		if($this->meta === self::FISH_SALMON){
			$name = "Raw Salmon";
		}elseif($this->meta === self::FISH_CLOWNFISH){
			$name = "Clownfish";
		}elseif($this->meta === self::FISH_PUFFERFISH){
			$name = "Pufferfish";
		}
		parent::__construct(self::RAW_FISH, $meta, $count, $name);
	}

	public function getFoodRestore(){
		if($this->meta === self::FISH_FISH){
			return 2;
		}elseif($this->meta === self::FISH_SALMON){
			return 2;
		}elseif($this->meta === self::FISH_CLOWNFISH){
			return 1;
		}elseif($this->meta === self::FISH_PUFFERFISH){
			return 1.2;
		}
		return 0;
	}

	public function getSaturationRestore(){
		if($this->meta === self::FISH_FISH){
			return 0.4;
		}elseif($this->meta === self::FISH_SALMON){
			return 0.4;
		}elseif($this->meta === self::FISH_CLOWNFISH){
			return 0.2;
		}elseif($this->meta === self::FISH_PUFFERFISH){
			return 0.2;
		}
		return 0;
	}

	public function getAdditionalEffects(){
		return $this->meta === self::FISH_PUFFERFISH ? [
			Effect::getEffect(Effect::HUNGER)->setDuration(300)->setAmplifier(2),
			Effect::getEffect(Effect::NAUSEA)->setDuration(300)->setAmplifier(1),
			Effect::getEffect(Effect::POISON)->setDuration(1200)->setAmplifier(3),
		] : [];
	}
}
