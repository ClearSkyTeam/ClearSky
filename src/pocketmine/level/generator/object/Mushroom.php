<?php

namespace pocketmine\level\generator\object;

use pocketmine\block\Block;
use pocketmine\block\Sapling;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;
use pocketmine\block\RedMushroom;
use pocketmine\block\BrownMushroom;

abstract class Mushroom{
	public $overridable = [
		Block::AIR => true,
		6 => true,
		17 => true,
		18 => true,
		Block::SNOW_LAYER => true,
		Block::LOG2 => true,
		Block::LEAVES2 => true
	];

	public $type = 0;
	public $trunkBlock = Block::BROWN_MUSHROOM_BLOCK;
	public $leafBlock = Block::BROWN_MUSHROOM_BLOCK;
	public $treeHeight = 7;

	public static function growTree(ChunkManager $level, $x, $y, $z, Random $random, $type = 0){
		switch($type){
			case Block::BROWN_MUSHROOM:
				$tree = new BrownMushroomTree();
				break;
			case Block::RED_MUSHROOM:
				$tree = new RedMushroomTree();
				break;
			default:
				return false;
		}
		if($tree->canPlaceObject($level, $x, $y, $z, $random)){
			$tree->placeObject($level, $x, $y, $z, $random);
		}
	}


	public function canPlaceObject(ChunkManager $level, $x, $y, $z, Random $random){
		$radiusToCheck = 0;
		for($yy = 0; $yy < $this->treeHeight + 3; ++$yy){
			if($yy == 1 or $yy === $this->treeHeight){
				++$radiusToCheck;
			}
			for($xx = -$radiusToCheck; $xx < ($radiusToCheck + 1); ++$xx){
				for($zz = -$radiusToCheck; $zz < ($radiusToCheck + 1); ++$zz){
					if(!isset($this->overridable[$level->getBlockIdAt($x + $xx, $y + $yy, $z + $zz)])){
						return false;
					}
				}
			}
		}

		return true;
	}

	public function placeObject(ChunkManager $level, $x, $y, $z, Random $random){

		$this->placeTrunk($level, $x, $y, $z, $random, $this->treeHeight - 1);

		for($yy = $y - 3 + $this->treeHeight; $yy <= $y + $this->treeHeight; ++$yy){
			$yOff = $yy - ($y + $this->treeHeight);
			$mid = (int) (1 - $yOff / 2);
			for($xx = $x - $mid; $xx <= $x + $mid; ++$xx){
				$xOff = abs($xx - $x);
				for($zz = $z - $mid; $zz <= $z + $mid; ++$zz){
					$zOff = abs($zz - $z);
					if($xOff === $mid and $zOff === $mid and ($yOff === 0 or $random->nextBoundedInt(2) === 0)){
						continue;
					}
					if(!Block::$solid[$level->getBlockIdAt($xx, $yy, $zz)]){
						$level->setBlockIdAt($xx, $yy, $zz, $this->leafBlock);
						$level->setBlockDataAt($xx, $yy, $zz, $this->type);
					}
				}
			}
		}
	}

	protected function placeTrunk(ChunkManager $level, $x, $y, $z, Random $random, $trunkHeight){
		// The base dirt block
		$level->setBlockIdAt($x, $y - 1, $z, Block::DIRT);

		for($yy = 0; $yy < $trunkHeight; ++$yy){
			$blockId = $level->getBlockIdAt($x, $y + $yy, $z);
			if(isset($this->overridable[$blockId])){
				$level->setBlockIdAt($x, $y + $yy, $z, $this->trunkBlock);
				$level->setBlockDataAt($x, $y + $yy, $z, $this->type);
			}
		}
	}
}