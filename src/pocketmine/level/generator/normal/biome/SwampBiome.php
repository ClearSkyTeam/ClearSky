<?php
namespace pocketmine\level\generator\normal\biome;

class SwampBiome extends GrassyBiome{

	public function __construct(){
		parent::__construct();

		$this->setElevation(62, 63);

		$this->temperature = 0.8;
		$this->rainfall = 0.9;
	}

	public function getName(){
		return "Swamp";
	}

	public function getColor(){
		return 0x6a7039;
	}
}