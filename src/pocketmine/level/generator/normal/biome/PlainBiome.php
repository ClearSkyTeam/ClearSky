<?php

namespace pocketmine\level\generator\normal\biome;

use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\generator\populator\LilyPad;
use pocketmine\level\generator\populator\WaterPit;
use pocketmine\block\Block;
use pocketmine\block\Flower as FlowerBlock;
use pocketmine\level\generator\populator\Flower;
use pocketmine\level\generator\populator\Sugarcane;
use pocketmine\level\generator\populator\TallSugarcane;

class PlainBiome extends GrassyBiome{

	public function __construct(){
		parent::__construct();

		$sugarcane = new Sugarcane();
		$sugarcane->setBaseAmount(6);
		$tallSugarcane = new TallSugarcane();
		$tallSugarcane->setBaseAmount(60);
		$tallGrass = new TallGrass();
		$tallGrass->setBaseAmount(25);
		$waterPit = new WaterPit();
		$waterPit->setBaseAmount(9999);
		$lilyPad = new LilyPad();
		$lilyPad->setBaseAmount(8);

		$flower = new Flower();
		$flower->setBaseAmount(2);
		$flower->addType([Block::DANDELION, 0]);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_POPPY]);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_AZURE_BLUET]);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_RED_TULIP]);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_ORANGE_TULIP]);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_WHITE_TULIP]);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_PINK_TULIP]);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_OXEYE_DAISY]);

		$this->addPopulator($sugarcane);
		$this->addPopulator($tallSugarcane);
		$this->addPopulator($tallGrass);
		$this->addPopulator($flower);
		$this->addPopulator($waterPit);
		$this->addPopulator($lilyPad);

		$this->setElevation(61, 68);

		$this->temperature = 0.8;
		$this->rainfall = 0.4;
	}

	public function getName(){
		return "Plains";
	}
}
