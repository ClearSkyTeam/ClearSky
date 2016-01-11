<?php
namespace pocketmine\level\generator\normal\biome;



class DesertBiome extends SandyBiome{

	public function __construct(){
		parent::__construct();
		$this->setElevation(63, 74);

		$this->temperature = 2;
		$this->rainfall = 0;
	}

	public function getName(){
		return "Desert";
	}
}