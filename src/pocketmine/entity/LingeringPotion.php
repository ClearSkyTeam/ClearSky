<?php
namespace pocketmine\entity;

use pocketmine\level\format\FullChunk;
use pocketmine\level\particle\SpellParticle;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use pocketmine\item\Potion;
use pocketmine\entity\Effect;

class LingeringPotion extends ThrownPotion{
	const NETWORK_ID = 101;
	public function __construct(FullChunk $chunk, CompoundTag $nbt, Entity $shootingEntity = null){
		parent::__construct($chunk, $nbt, $shootingEntity);
	}

	public function kill(){
		/* @TODO: Spawn AreaEffectCloud */
		/* $color = Potion::getColor($this->getData());
		$this->getLevel()->addParticle(new SpellParticle($this, $color[0], $color[1], $color[2]));
		$players = $this->getViewers();
		foreach($players as $p){
			if($p->distance($this) <= 6){
				switch($this->getData()){
					case Potion::NIGHT_VISION:
						$p->addEffect(Effect::getEffect(Effect::NIGHT_VISION)->setAmplifier(0)->setDuration(3 * 60 * 20));
						break;
					case Potion::NIGHT_VISION_T:
						$p->addEffect(Effect::getEffect(Effect::NIGHT_VISION)->setAmplifier(0)->setDuration(8 * 60 * 20));
						break;
					case Potion::INVISIBILITY:
						$p->addEffect(Effect::getEffect(Effect::INVISIBILITY)->setAmplifier(0)->setDuration(3 * 60 * 20));
						break;
					case Potion::INVISIBILITY_T:
						$p->addEffect(Effect::getEffect(Effect::INVISIBILITY)->setAmplifier(0)->setDuration(8 * 60 * 20));
						break;
					case Potion::LEAPING:
						$p->addEffect(Effect::getEffect(Effect::JUMP)->setAmplifier(0)->setDuration(3 * 60 * 20));
						break;
					case Potion::LEAPING_T:
						$p->addEffect(Effect::getEffect(Effect::JUMP)->setAmplifier(0)->setDuration(8 * 60 * 20));
						break;
					case Potion::LEAPING_TWO:
						$p->addEffect(Effect::getEffect(Effect::JUMP)->setAmplifier(1)->setDuration(1.5 * 60 * 20));
						break;
					case Potion::FIRE_RESISTANCE:
						$p->addEffect(Effect::getEffect(Effect::FIRE_RESISTANCE)->setAmplifier(0)->setDuration(3 * 60 * 20));
						break;
					case Potion::FIRE_RESISTANCE_T:
						$p->addEffect(Effect::getEffect(Effect::FIRE_RESISTANCE)->setAmplifier(0)->setDuration(8 * 60 * 20));
						break;
					case Potion::SPEED:
						$p->addEffect(Effect::getEffect(Effect::SPEED)->setAmplifier(0)->setDuration(3 * 60 * 20));
						break;
					case Potion::SPEED_T:
						$p->addEffect(Effect::getEffect(Effect::SPEED)->setAmplifier(0)->setDuration(8 * 60 * 20));
						break;
					case Potion::SPEED_TWO:
						$p->addEffect(Effect::getEffect(Effect::SPEED)->setAmplifier(1)->setDuration(1.5 * 60 * 20));
						break;
					case Potion::SLOWNESS:
						$p->addEffect(Effect::getEffect(Effect::SLOWNESS)->setAmplifier(0)->setDuration(1 * 60 * 20));
						break;
					case Potion::SLOWNESS_T:
						$p->addEffect(Effect::getEffect(Effect::SLOWNESS)->setAmplifier(0)->setDuration(4 * 60 * 20));
						break;
					case Potion::WATER_BREATHING:
						$p->addEffect(Effect::getEffect(Effect::WATER_BREATHING)->setAmplifier(0)->setDuration(3 * 60 * 20));
						break;
					case Potion::WATER_BREATHING_T:
						$p->addEffect(Effect::getEffect(Effect::WATER_BREATHING)->setAmplifier(0)->setDuration(8 * 60 * 20));
						break;
					case Potion::POISON:
						if($p->isSurvival()){$p->addEffect(Effect::getEffect(Effect::POISON)->setAmplifier(0)->setDuration(45 * 20));}
						break;
					case Potion::POISON_T:
						if($p->isSurvival()){$p->addEffect(Effect::getEffect(Effect::POISON)->setAmplifier(0)->setDuration(2 * 60 * 20));}
						break;
					case Potion::POISON_TWO:
						if($p->isSurvival()){$p->addEffect(Effect::getEffect(Effect::POISON)->setAmplifier(0)->setDuration(22 * 20));}
						break;
					case Potion::REGENERATION:
						if($p->isSurvival()){$p->addEffect(Effect::getEffect(Effect::REGENERATION)->setAmplifier(0)->setDuration(45 * 20));}
						break;
					case Potion::REGENERATION_T:
						if($p->isSurvival()){$p->addEffect(Effect::getEffect(Effect::REGENERATION)->setAmplifier(0)->setDuration(2 * 60 * 20));}
						break;
					case Potion::REGENERATION_TWO:
						if($p->isSurvival()){$p->addEffect(Effect::getEffect(Effect::REGENERATION)->setAmplifier(1)->setDuration(22 * 20));}
						break;
					case Potion::STRENGTH:
						$p->addEffect(Effect::getEffect(Effect::STRENGTH)->setAmplifier(0)->setDuration(3 * 60 * 20));
						break;
					case Potion::STRENGTH_T:
						$p->addEffect(Effect::getEffect(Effect::STRENGTH)->setAmplifier(0)->setDuration(8 * 60 * 20));
						break;
					case Potion::STRENGTH_TWO:
						$p->addEffect(Effect::getEffect(Effect::STRENGTH)->setAmplifier(1)->setDuration(1.5 * 60 * 20));
						break;
					case Potion::WEAKNESS:
						$p->addEffect(Effect::getEffect(Effect::WEAKNESS)->setAmplifier(0)->setDuration(1.5 * 60 * 20));
						break;
					case Potion::WEAKNESS_T:
						$p->addEffect(Effect::getEffect(Effect::WEAKNESS)->setAmplifier(0)->setDuration(4 * 60 * 20));
						break;
					case Potion::HEALING:
						if($p->isSurvival()){$p->addEffect(Effect::getEffect(Effect::HEALING)->setAmplifier(0)->setDuration(1));}
						break;
					case Potion::HEALING_TWO:
						if($p->isSurvival()){$p->addEffect(Effect::getEffect(Effect::HEALING)->setAmplifier(1)->setDuration(1));}
						break;
					case Potion::HARMING:
						if($p->isSurvival()){$p->addEffect(Effect::getEffect(Effect::HARMING)->setAmplifier(0)->setDuration(1));}
						break;
					case Potion::HARMING_TWO:
						if($p->isSurvival()){$p->addEffect(Effect::getEffect(Effect::HARMING)->setAmplifier(1)->setDuration(1));}
						break;
				}	
			}
		}*/
		
		parent::kill();
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}
}
