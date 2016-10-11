<?php

namespace pocketmine\level\generator\object;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;

class BigRedMushroom extends Mushroom{

	protected $superMushroom = false;

	public function __construct($superMushroom = false){
		$this->trunkBlock = Block::RED_MUSHROOM_BLOCK;
		$this->leafBlock = Block::RED_MUSHROOM_BLOCK;
		$this->trunkBlock = Block::RED_MUSHROOM_BLOCK;
		$this->type = 15;//0 15 14 14
		$this->superMushroom = (bool) $superMushroom;
	}

	public function placeObject(ChunkManager $level, $x, $y, $z, Random $random){
		#$this->treeHeight = $random->nextBoundedInt(2) + 5;
		$this->treeHeight = $random->nextRange(0,2) + 5;
		if($this->superMushroom){
			$this->treeHeight * 2;
		}
		$this->placeTrunk($level, $x, $y, $z, $random, $this->treeHeight);
		$yyy = $this->treeHeight + $y;
		
		for($xx = $x - 2; $xx <= $x + 2; ++$xx){
			for($zz = $z - 2; $zz <= $z + 2; ++$zz){
				for($yy = $yyy - 3; $yy <= $yyy; ++$yy){
					
					if((!Block::$solid[$level->getBlockIdAt($xx, $yy, $zz)] || isset($this->overridable[$level->getBlockIdAt($xx, $yy, $zz)]))){
						if($yy != $yyy && ($xx == $x - 2 || $xx == $x + 2 || $zz == $z - 2 || $zz == $z + 2) && !(($xx == $x - 2 || $xx == $x + 2) && ($zz == $z - 2 || $zz == $z + 2))){
						
							$level->setBlockIdAt($xx, $yy, $zz, $this->leafBlock);
							$level->setBlockDataAt($xx, $yy, $zz, 14);
						}elseif ($yy == $yyy && !($xx == $x - 2 || $xx == $x + 2 || $zz == $z - 2 || $zz == $z + 2)){
							$level->setBlockIdAt($xx, $yy, $zz, $this->leafBlock);
							$level->setBlockDataAt($xx, $yy, $zz, 14);
						}
					}
				}
			}
		}
	}
	// 						if(!(($yy == $this->treeHeight && (!($xx == $x - 2 || $xx == $x + 2 || $zz == $z - 2 || $zz == $z + 2) || (($xx == $x - 2 || $xx == $x + 2)) && ($zz == $z - 2 || $zz == $z + 2))) /*unten*/ || ($yy == $this->treeHeight && !($xx == $x - 2 || $xx == $x + 2 || $zz == $z - 2 || $zz == $z + 2)) /*top layer*/)){
	
}