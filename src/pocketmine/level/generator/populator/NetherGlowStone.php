<?php

namespace pocketmine\level\generator\populator;

use pocketmine\block\Glowstone;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\object\NetherOreTop as ObjectOre;
use pocketmine\level\generator\object\OreType;
use pocketmine\utils\Random;

class NetherGlowStone extends Populator{

	/** @var ChunkManager */
	private $level;

	public function populate(ChunkManager $level, $chunkX, $chunkZ, Random $random){
		$this->level = $level;
		$type = new OreType(new Glowstone(), 1, 20, 128, 10);
		$ore = new ObjectOre($random, $type);
		for($i = 0; $i < $ore->type->clusterCount; ++$i){
			$x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
			$z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
			$y = $this->getHighestWorkableBlock($x, $z);
			$ore->placeObject($level, $x, $y, $z);
		}
	}

	private function getHighestWorkableBlock($x, $z){
		for($y = 127; $y >= 0; --$y){
			$b = $this->level->getBlockIdAt($x, $y, $z);
			if($b == 0){
				break;
			}
		}

		return $y === 0 ? -1 : ++$y;
	}

}