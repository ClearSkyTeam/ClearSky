<?php
namespace pocketmine\item;

use pocketmine\entity\Effect;
class Potion extends Food{
	const WATER_BOTTLE = 0;
	const AWKWARD = 4;
	const THICK = 3;
	const MUNDANE_EXTENDED = 2;
	const MUNDANE = 1;
	const REGENERATION = 28;
	const REGENERATION_T = 29;
	const REGENERATION_TWO = 30;
	const SPEED = 14;
	const SPEED_T = 15;
	const SPEED_TWO = 16;
	const FIRE_RESISTANCE = 12;
	const FIRE_RESISTANCE_T = 13;
	const HEALING = 21;
	const HEALING_TWO = 22;
	const NIGHT_VISION = 5;
	const NIGHT_VISION_T = 6;
	const STRENGTH = 31;
	const STRENGTH_T = 32;
	const STRENGTH_TWO = 33;
	const LEAPING = 9;
	const LEAPING_T = 10;
	const LEAPING_TWO = 11;
	const WATER_BREATHING = 19;
	const WATER_BREATHING_T = 20;
	const INVISIBILITY = 7;
	const INVISIBILITY_T = 8;
	const POISON = 25;
	const POISON_T = 26;
	const POISON_TWO = 27;
	const WEAKNESS = 34;
	const WEAKNESS_T = 35;
	const SLOWNESS = 17;
	const SLOWNESS_T = 18;
	const HARMING = 23;
	const HARMING_TWO = 24;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::POTION, $meta, $count, $this->getNameByMeta($meta));
	}

	public function getNameByMeta($meta){
		switch($meta){
			case self::WATER_BOTTLE:
				return "Water Bottle";
			case self::MUNDANE:
			case self::MUNDANE_EXTENDED:
				return "Mundane Potion";
			case self::THICK:
				return "Thick Potion";
			case self::AWKWARD:
				return "Awkward Potion";
			case self::INVISIBILITY:
			case self::INVISIBILITY_T:
				return "Potion of Invisibility";
			case self::LEAPING:
			case self::LEAPING_T:
				return "Potion of Leaping";
			case self::LEAPING_TWO:
				return "Potion of Leaping II";
			case self::FIRE_RESISTANCE:
			case self::FIRE_RESISTANCE_T:
				return "Potion of Fire Residence";
			case self::SPEED:
			case self::SPEED_T:
				return "Potion of Speed";
			case self::SPEED_TWO:
				return "Potion of Speed II";
			case self::SLOWNESS:
			case self::SLOWNESS_T:
				return "Potion of Slowness";
			case self::WATER_BREATHING:
			case self::WATER_BREATHING_T:
				return "Potion of Water Breathing";
			case self::HARMING:
				return "Potion of Harming";
			case self::HARMING_TWO:
				return "Potion of Harming II";
			case self::POISON:
			case self::POISON_T:
				return "Potion of Poison";
			case self::POISON_TWO:
				return "Potion of Poison II";
			case self::HEALING:
				return "Potion of Healing";
			case self::HEALING_TWO:
				return "Potion of Healing II";
			default:
				return "Potion";
		}
	}

	public function getEffects(){
		$effect = [];
		switch($this->meta){
			case Potion::NIGHT_VISION:
				$effect = [[Effect::getEffect(Effect::NIGHT_VISION)->setAmplifier(0)->setDuration(3 * 60 * 20), 1]];
				break;
			case Potion::NIGHT_VISION_T:
				$effect = [[Effect::getEffect(Effect::NIGHT_VISION)->setAmplifier(0)->setDuration(8 * 60 * 20), 1]];
				break;
			case Potion::INVISIBILITY:
				$effect = [[Effect::getEffect(Effect::INVISIBILITY)->setAmplifier(0)->setDuration(3 * 60 * 20), 1]];
				break;
			case Potion::INVISIBILITY_T:
				$effect = [[Effect::getEffect(Effect::INVISIBILITY)->setAmplifier(0)->setDuration(8 * 60 * 20), 1]];
				break;
			case Potion::LEAPING:
				$effect = [[Effect::getEffect(Effect::JUMP)->setAmplifier(0)->setDuration(3 * 60 * 20), 1]];
				break;
			case Potion::LEAPING_T:
				$effect = [[Effect::getEffect(Effect::JUMP)->setAmplifier(0)->setDuration(8 * 60 * 20), 1]];
				break;
			case Potion::LEAPING_TWO:
				$effect = [[Effect::getEffect(Effect::JUMP)->setAmplifier(1)->setDuration(1.5 * 60 * 20), 1]];
				break;
			case Potion::FIRE_RESISTANCE:
				$effect = [[Effect::getEffect(Effect::FIRE_RESISTANCE)->setAmplifier(0)->setDuration(3 * 60 * 20), 1]];
				break;
			case Potion::FIRE_RESISTANCE_T:
				$effect = [[Effect::getEffect(Effect::FIRE_RESISTANCE)->setAmplifier(0)->setDuration(8 * 60 * 20), 1]];
				break;
			case Potion::SPEED:
				$effect = [[Effect::getEffect(Effect::SPEED)->setAmplifier(0)->setDuration(3 * 60 * 20), 1]];
				break;
			case Potion::SPEED_T:
				$effect = [[Effect::getEffect(Effect::SPEED)->setAmplifier(0)->setDuration(8 * 60 * 20), 1]];
				break;
			case Potion::SPEED_TWO:
				$effect = [[Effect::getEffect(Effect::SPEED)->setAmplifier(1)->setDuration(1.5 * 60 * 20), 1]];
				break;
			case Potion::SLOWNESS:
				$effect = [[Effect::getEffect(Effect::SLOWNESS)->setAmplifier(0)->setDuration(1 * 60 * 20), 1]];
				break;
			case Potion::SLOWNESS_T:
				$effect = [[Effect::getEffect(Effect::SLOWNESS)->setAmplifier(0)->setDuration(4 * 60 * 20), 1]];
				break;
			case Potion::WATER_BREATHING:
				$effect = [[Effect::getEffect(Effect::WATER_BREATHING)->setAmplifier(0)->setDuration(3 * 60 * 20), 1]];
				break;
			case Potion::WATER_BREATHING_T:
				$effect = [[Effect::getEffect(Effect::WATER_BREATHING)->setAmplifier(0)->setDuration(8 * 60 * 20), 1]];
				break;
			case Potion::POISON:
				$effect = [[Effect::getEffect(Effect::POISON)->setAmplifier(0)->setDuration(45 * 20), 1]];
				break;
			case Potion::POISON_T:
				$effect = [[Effect::getEffect(Effect::POISON)->setAmplifier(0)->setDuration(2 * 60 * 20), 1]];
				break;
			case Potion::POISON_TWO:
				$effect = [[Effect::getEffect(Effect::POISON)->setAmplifier(0)->setDuration(22 * 20), 1]];
				break;
			case Potion::REGENERATION:
				$effect = [[Effect::getEffect(Effect::REGENERATION)->setAmplifier(0)->setDuration(45 * 20), 1]];
				break;
			case Potion::REGENERATION_T:
				$effect = [[Effect::getEffect(Effect::REGENERATION)->setAmplifier(0)->setDuration(2 * 60 * 20), 1]];
				break;
			case Potion::REGENERATION_TWO:
				$effect = [[Effect::getEffect(Effect::REGENERATION)->setAmplifier(1)->setDuration(22 * 20), 1]];
				break;
			case Potion::STRENGTH:
				$effect = [[Effect::getEffect(Effect::STRENGTH)->setAmplifier(0)->setDuration(3 * 60 * 20), 1]];
				break;
			case Potion::STRENGTH_T:
				$effect = [[Effect::getEffect(Effect::STRENGTH)->setAmplifier(0)->setDuration(8 * 60 * 20), 1]];
				break;
			case Potion::STRENGTH_TWO:
				$effect = [[Effect::getEffect(Effect::STRENGTH)->setAmplifier(1)->setDuration(1.5 * 60 * 20), 1]];
				break;
			case Potion::WEAKNESS:
				$effect = [[Effect::getEffect(Effect::WEAKNESS)->setAmplifier(0)->setDuration(1.5 * 60 * 20), 1]];
				break;
			case Potion::WEAKNESS_T:
				$effect = [[Effect::getEffect(Effect::WEAKNESS)->setAmplifier(0)->setDuration(4 * 60 * 20), 1]];
				break;
			case Potion::HEALING:
				$effect = [[Effect::getEffect(Effect::HEALING)->setAmplifier(0)->setDuration(1), 1]];
				break;
			case Potion::HEALING_TWO:
				$effect = [[Effect::getEffect(Effect::HEALING)->setAmplifier(1)->setDuration(1), 1]];
				break;
			case Potion::HARMING:
				$effect = [[Effect::getEffect(Effect::HARMING)->setAmplifier(0)->setDuration(1), 1]];
				break;
			case Potion::HARMING_TWO:
				$effect = [[Effect::getEffect(Effect::HARMING)->setAmplifier(1)->setDuration(1), 1]];
				break;
			default:
				$effect = [];
				break;
		}
		return $effect;
	}
}