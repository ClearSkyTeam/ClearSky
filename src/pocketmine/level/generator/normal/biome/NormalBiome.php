<?php
namespace pocketmine\level\generator\normal\biome;

use pocketmine\level\generator\biome\Biome;

abstract class NormalBiome extends Biome{

	public function getColor(){
		return $this->grassColor;
	}
}
