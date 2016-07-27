<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_| 
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 * 
 *
*/

namespace pocketmine\level\generator\object;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\math\Vector2;
use pocketmine\math\Vector3;
use pocketmine\utils\VectorIterator;
use pocketmine\utils\Random;
use pocketmine\level\Level;

class AcaciaTree2 extends Tree{
	public $overridable = [
		Block::AIR => true,
		Block::LEAVES => true,
		Block::SAPLING => true
	];

	/** @var Random */
	private $random;
	private $trunkHeightMultiplier = 0.6;
	private $trunkHeight;
	private $leafAmount = 1;
	private $leafDistanceLimit = 6;
	private $widthScale = 1;
	private $branchSlope = 0.5;
	private $leavesHeight = 2;
	protected $radiusIncrease = -1;
	private $addLeavesVines = false;
	private $addLogVines = false;
	private $addCocoaPlants = false;
	private $totalHeight;
	private $baseHeight = 3;

	public function canPlaceObject(ChunkManager $level, $x, $y, $z, Random $random){
		if(!parent::canPlaceObject($level, $x, $y, $z, $random) or $level->getBlockIdAt($x, $y, $z) == Block::WATER or $level->getBlockIdAt($x, $y, $z) == Block::STILL_WATER){
			return false;
		}
		$base = new Vector3($x, $y, $z);
		$this->totalHeight = $this->baseHeight + $random->nextBoundedInt(12);
		$availableSpace = $this->getAvailableBlockSpace($level, $base, $base->add(0, $this->totalHeight - 1, 0));
		if($availableSpace > $this->baseHeight or $availableSpace == -1){
			if($availableSpace != -1){
				$this->totalHeight = $availableSpace;
			}
			return true;
		}
		return false;
	}

	public function placeObject(ChunkManager $level, $x, $y, $z, Random $random){
		$this->random = $random;
		$this->trunkHeight = (int) ($this->totalHeight * $this->trunkHeightMultiplier);
		$leaves = $this->getLeafGroupPoints($level, $x, $y, $z);
		$trunk = new VectorIterator($level, new Vector3($x, $y, $z), new Vector3($x, $y + $this->trunkHeight, $z));
		while($trunk->valid()){
			$trunk->next();
			$pos = $trunk->current();
			$level->setBlockIdAt($pos->x, $pos->y, $pos->z, Block::LOG2);
			$level->setBlockDataAt($pos->x, $pos->y, $pos->z, 0);
		}
		$this->generateBranches($level, $x, $y, $z, $leaves);
	}

	private function getLeafGroupPoints(ChunkManager $level, $x, $y, $z){
		$amount = $this->leafAmount * $this->totalHeight / 13;
		$groupsPerLayer = (int) (0.1 + $amount * $amount);

		if($groupsPerLayer == 0){
			$groupsPerLayer = 1;
		}

		$trunkTopY = $y + $this->trunkHeight;
		$groups = [];
		$groupY = $y + $this->totalHeight - $this->leafDistanceLimit;
		$groups[] = [new Vector3($x, $groupY, $z), $trunkTopY];

		($currentLiar1 = (int) ($this->totalHeight - $this->leafDistanceLimit));
		($currentLiar2 = (int) ($this->trunkHeight - $this->leafDistanceLimit));
		if($currentLiar1 + $currentLiar2 < 0){
			$level->getChunk($x << 4, $z << 4)->getProvider()->getLevel()->getServer()->broadcastMessage("§4§lblöder BLÖDER BÖÖÖÖSER BAUM!!!");
		}
		
		for($currentLayer = (int) ($this->totalHeight - $this->leafDistanceLimit); $currentLayer >= 0; $currentLayer--){
			$layerSize = $this->getRoughLayerSize($currentLayer);

			if($layerSize < 0){
				$groupY--;
				continue;
			}

			for($count = 0; $count < $groupsPerLayer; $count++){
				$scale = $this->widthScale * $layerSize * ($this->random->nextFloat() + 0.328);
				$randomOffset = Vector2::createRandomDirection($this->random)->multiply($scale);
				$groupX = (int) ($randomOffset->getX() + $x + 0.5);
				$groupZ = (int) ($randomOffset->getY() + $z + 0.5);
				$group = new Vector3($groupX, $groupY, $groupZ);
				if($this->getAvailableBlockSpace($level, $group, $group->add(0, $this->leafDistanceLimit, 0)) != -1){
					continue;
				}
				$xOff = (int) ($x - $groupX);
				$zOff = (int) ($z - $groupZ);
				$horizontalDistanceToTrunk = sqrt($xOff * $xOff + $zOff * $zOff);
				$verticalDistanceToTrunk = $horizontalDistanceToTrunk * $this->branchSlope;
				$yDiff = (int) ($groupY - $verticalDistanceToTrunk);

				if($yDiff > $trunkTopY){
					$base = $trunkTopY;
				}else{
					$base = $yDiff;
				}
				if($this->getAvailableBlockSpace($level, new Vector3($x, $base, $z), $group) == -1){
					$groups[] = [$group, $base];
				}
			}
			$groupY--;
		}
		return $groups;
	}

	private function getLeafGroupLayerSize(int $y){
		if($y >= 0 and $y < $this->leafDistanceLimit){
			return (int) (($y != ($this->leafDistanceLimit - 1)) ? 3 : 2);
		}
		return -1;
	}

	private function generateGroupLayer(ChunkManager $level, int $x, int $y, int $z, int $size){
		(int) $i3 = $x;
		(int) $j1 = $z;
		(int) $k1 = $y;

		$blockpos2 = new Vector3($i3, $k1, $j1);
			
		for((int) $j3 = -3; $j3 <= 3; ++$j3){
			for((int) $i4 = -3; $i4 <= 3; ++$i4){
				if(abs($j3) != 3 || abs($i4) != 3){
					$this->setLeavesBlock($level, $blockpos2->add($j3, 0, $i4));
				}
			}
		}
			
		$blockpos2 = $blockpos2->getSide(Vector3::SIDE_UP);
			
		for((int) $k3 = -1; $k3 <= 1; ++$k3){
			for((int) $j4 = -1; $j4 <= 1; ++$j4){
				$this->setLeavesBlock($level, $blockpos2->add($k3, 0, $j4));
			}
		}
			
		$this->setLeavesBlock($level, $blockpos2->getSide(Vector3::SIDE_EAST, 2));
		$this->setLeavesBlock($level, $blockpos2->getSide(Vector3::SIDE_WEST, 2));
		$this->setLeavesBlock($level, $blockpos2->getSide(Vector3::SIDE_SOUTH, 2));
		$this->setLeavesBlock($level, $blockpos2->getSide(Vector3::SIDE_NORTH, 2));

/*		$k2 = $k1;
		(int) $l3 = $k2 - mt_rand(0, 2) - 1;
		$l4 = $l3;
		(int) $j2 = $y + $l4;
		$k1 = $j2;

		if($k1 > 0){
			$blockpos3 = new Vector3($i3, $k1, $j1);
				
			for((int) $i5 = -2; $i5 <= 2; ++$i5){
				for((int) $k5 = -2; $k5 <= 2; ++$k5){
					if(abs($i5) != 2 || abs($k5) != 2){
						$this->setLeavesBlock($level, $blockpos3->add($i5, 0, $k5));
					}
				}
			}
				
			$blockpos3 = $blockpos3->getSide(Vector3::SIDE_UP);
				
			for((int) $j5 = -1; $j5 <= 1; ++$j5){
				for((int) $l5 = -1; $l5 <= 1; ++$l5){
					$this->setLeavesBlock($level, $blockpos3->add($j5, 0, $l5));
				}
			}
		}*/
	}

	private function getRoughLayerSize(int $layer) : float {
		$halfHeight = $this->totalHeight / 2;
		if($layer < ($this->totalHeight / 3)){
			return -1;
		}elseif($layer == $halfHeight){
			return $halfHeight / 4;
		}elseif($layer >= $this->totalHeight or $layer <= 0){
			return 0;
		}else{
			return sqrt($halfHeight * $halfHeight - ($layer - $halfHeight) * ($layer - $halfHeight)) / 2;
		}
	}

	private function generateBranches(ChunkManager $level, int $x, int $y, int $z, array $groups){
		print_r($groups);
		foreach($groups as $group){
			$baseY = $group[1];
			if(($baseY - $y) >= ($this->totalHeight * 0.2)){
				$base = new Vector3($x, $baseY, $z);
				$branch = new VectorIterator($level, $base, $group[0]);
				while($branch->valid()){
					$branch->next();
					$pos = $branch->current();
					$level->setBlockIdAt((int) $pos->x, (int) $pos->y, (int) $pos->z, Block::LOG2);
					$level->setBlockDataAt((int) $pos->x, (int) $pos->y, (int) $pos->z, 0);
					#$level->updateBlockLight((int) $pos->x, (int) $pos->y, (int) $pos->z);
				}
				$this->generateGroupLayer($level, $group[0]->x, $group[0]->y + 1, $group[0]->z, 0);
			}
		}
	}

	private function getAvailableBlockSpace(ChunkManager $level, Vector3 $from, Vector3 $to){
		$count = 0;
		$iter = new VectorIterator($level, $from, $to);
		while($iter->valid()){
			$iter->next();
			$pos = $iter->current();
			if(!isset($this->overridable[$level->getBlockIdAt($pos->x, $pos->y, $pos->z)])){
				return $count;
			}
			$count++;
		}
		return -1;
	}
	
	private function setLeavesBlock(Level $level, Vector3 $pos){
		if(isset($this->overridable[$level->getBlockIdAt($pos->x, $pos->y, $pos->z)])){
			$level->setBlockIdAt($pos->x, $pos->y, $pos->z, Block::LEAVES2);
			$level->setBlockDataAt($pos->x, $pos->y, $pos->z, 0);
		}
	}
}