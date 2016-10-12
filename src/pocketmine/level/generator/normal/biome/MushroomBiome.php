<?php

namespace pocketmine\level\generator\normal\biome;

use pocketmine\block\Block;
use pocketmine\level\generator\populator\Flower;
use pocketmine\level\generator\populator\BigMushroom;

class MushroomBiome extends GrassyBiome{

	public function __construct(){
		parent::__construct();

		$this->setGroundCover([
			Block::get(Block::MYCELIUM, 0),
			Block::get(Block::DIRT, 0),
			Block::get(Block::DIRT, 0),
		]);

		$brownMushroom = new BigMushroom(Block::BROWN_MUSHROOM);
		$brownMushroom->setBaseAmount(0.1);
		$redMushroom = new BigMushroom(Block::RED_MUSHROOM);
		$redMushroom->setBaseAmount(0.1);

		$flower = new Flower();
		$flower->setBaseAmount(2);
		$flower->addType([Block::RED_MUSHROOM, 0]);
		$flower->addType([Block::BROWN_MUSHROOM, 0]);

		$this->addPopulator($flower);
		$this->addPopulator($brownMushroom);
		$this->addPopulator($redMushroom);

		$this->setElevation(61, 68);

		$this->temperature = 0.8;
		$this->rainfall = 0.4;
	}

	public function getName(){
		return "Mushroom";
	}
}
