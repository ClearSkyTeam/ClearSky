<?php

namespace pocketmine\level\generator\normal\biome;

use pocketmine\block\Sapling;
use pocketmine\level\generator\populator\Tree;
use pocketmine\level\generator\populator\TallGrass;
use pocketmine\block\Flower as FlowerBlock;
use pocketmine\block\Block;
use pocketmine\level\generator\populator\Flower;

class SavannaBiome extends GrassyBiome{

	public function __construct(){
		parent::__construct();

		$trees = new Tree(Sapling::ACACIA);
		$trees->setBaseAmount(5);

		$tallGrass = new TallGrass();
		$tallGrass->setBaseAmount(25);

		$flower = new Flower();
		$flower->setBaseAmount(1);
		$flower->addType([Block::DANDELION, 0]);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_POPPY]);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_RED_TULIP]);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_ORANGE_TULIP]);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_WHITE_TULIP]);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_PINK_TULIP]);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_OXEYE_DAISY]);

		$this->addPopulator($trees);
		$this->addPopulator($tallGrass);
		$this->addPopulator($flower);

		$this->setElevation(61, 68);
		
		$this->temperature = 1.6;
		$this->rainfall = 0;
	}

	public function getName(){
		return "FakeSavanna";
	}
}