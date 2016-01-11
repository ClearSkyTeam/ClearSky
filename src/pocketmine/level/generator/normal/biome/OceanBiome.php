<?php
namespace pocketmine\level\generator\normal\biome;

use pocketmine\level\generator\populator\TallGrass;

class OceanBiome extends GrassyBiome{

	public function __construct(){
		parent::__construct();

		$tallGrass = new TallGrass();
		$tallGrass->setBaseAmount(5);

		$this->addPopulator($tallGrass);

		$this->setElevation(46, 58);

		$this->temperature = 0.5;
		$this->rainfall = 0.5;
	}

	public function getName(){
		return "Ocean";
	}
}