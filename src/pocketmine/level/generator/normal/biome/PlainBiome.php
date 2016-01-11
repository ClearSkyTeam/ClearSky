<?php
namespace pocketmine\level\generator\normal\biome;

use pocketmine\level\generator\populator\TallGrass;

class PlainBiome extends GrassyBiome{

	public function __construct(){
		parent::__construct();

		$tallGrass = new TallGrass();
		$tallGrass->setBaseAmount(12);

		$this->addPopulator($tallGrass);

		$this->setElevation(63, 74);

		$this->temperature = 0.8;
		$this->rainfall = 0.4;
	}

	public function getName(){
		return "Plains";
	}
}