<?php
namespace pocketmine\item;

use pocketmine\Player;
abstract class Food extends Item{
	public $saturation = 0;

	public function getSaturation(){
		return $this->saturation;
	}

	/**
	 *
	 * @param
	 *        	saturation (float) $float
	 */
	public function setSaturation($float){
		return $this->saturation = $float;
	}

	/**
	 *
	 * @param
	 *        	array([Effect, chance])
	 */
	public function getEffects(){
		return [];
	}

	/**
	 *
	 * @param
	 *        	Effects (array) $effects
	 */
	public function setEffects($effects){
		return $this->effects = $effects;
	}

	/**
	 *
	 * @param Player $player        	
	 */
	public function giveEffects(Player $player){
		$effects = $this->getEffects();
		foreach ($effects as $effect){
			$player->addEffect($effect);
		}
	}
}
