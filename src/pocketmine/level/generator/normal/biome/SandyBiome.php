<?php
namespace pocketmine\level\generator\normal\biome;

use pocketmine\block\Block;

abstract class SandyBiome extends NormalBiome{

	public function __construct(){
		$this->setGroundCover([
			Block::get(Block::SAND, 0),
			Block::get(Block::SAND, 0),
			Block::get(Block::SANDSTONE, 0),
			Block::get(Block::SANDSTONE, 0),
			Block::get(Block::SANDSTONE, 0),
		]);
	}
}