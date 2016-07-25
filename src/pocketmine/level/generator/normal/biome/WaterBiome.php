<?php

namespace pocketmine\level\generator\normal\biome;

use pocketmine\block\Block;

abstract class WaterBiome extends NormalBiome{

	public function __construct(){
		$this->setGroundCover([
			Block::get(Block::GRAVEL, 0),
			Block::get(Block::DIRT, 0),
			Block::get(Block::DIRT, 0),
		]);
	}
}