<?php
namespace pocketmine\level\generator\normal\biome;

use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\generator\populator\Tree;

class MountainsBiome extends GrassyBiome{

	public function __construct(){
		parent::__construct();

		$trees = new Tree();
		$trees->setBaseAmount(1);
		$this->addPopulator($trees);

		$tallGrass = new TallGrass();
		$tallGrass->setBaseAmount(1);

		$this->addPopulator($tallGrass);

		//TODO: add emerald

		$this->setElevation(63, 127);

		$this->temperature = 0.4;
		$this->rainfall = 0.5;
	}

	public function getName(){
		return "Mountains";
	}
}