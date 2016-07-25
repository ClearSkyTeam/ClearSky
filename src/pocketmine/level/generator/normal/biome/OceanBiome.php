<?php

namespace pocketmine\level\generator\normal\biome;

use pocketmine\level\generator\populator\Sugarcane;
use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\generator\populator\TallSugarcane;

class OceanBiome extends WaterBiome{

	public function __construct(){
		parent::__construct();

		$sugarcane = new Sugarcane();
		$sugarcane->setBaseAmount(6);
		$tallSugarcane = new TallSugarcane();
		$tallSugarcane->setBaseAmount(60);
		$tallGrass = new TallGrass();
		$tallGrass->setBaseAmount(5);

		$this->addPopulator($sugarcane);
		$this->addPopulator($tallSugarcane);
		$this->addPopulator($tallGrass);


		$this->setElevation(46, 68);

		$this->temperature = 0.5;
		$this->rainfall = 0.5;
	}

	public function getName(){
		return "Ocean";
	}
}
