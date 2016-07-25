<?php

namespace pocketmine\level\generator\normal\biome;

use pocketmine\block\Sapling;
use pocketmine\block\Block;
use pocketmine\level\generator\populator\MossStone;
use pocketmine\level\generator\populator\Tree;
use pocketmine\level\generator\object\BigTree;

class MegaTaigaBiome extends NormalBiome{

	public function __construct(){
		parent::__construct();

		$trees = new BigTree(Sapling::SPRUCE);
		$trees->setBaseAmount(10);
		$this->addPopulator($trees);

		$mossStone = new MossStone();
		$mossStone->setBaseAmount(1);

		$this->addPopulator($mossStone);

		$this->setElevation(63, 81);

		$this->temperature = 0.05;
		$this->rainfall = 0.8;

		$this->setGroundCover([
			Block::get(Block::PODZOL, 0),
			Block::get(Block::PODZOL, 0),
		]);
	}

	public function getName(){
		return "MegaTaiga";
	}
}
