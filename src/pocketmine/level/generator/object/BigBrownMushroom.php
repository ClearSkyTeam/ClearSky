<?php

namespace pocketmine\level\generator\object;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;

class BigBrownMushroom extends Mushroom{

	protected $superMushroom = false;

	public function __construct($superMushroom = false){
		$this->trunkBlock = Block::BROWN_MUSHROOM_BLOCK;
		$this->leafBlock = Block::BROWN_MUSHROOM_BLOCK;
		$this->trunkBlock = Block::BROWN_MUSHROOM_BLOCK;
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
		
		for($xx = $x - 3; $xx <= $x + 3; ++$xx){
			for($zz = $z - 3; $zz <= $z + 3; ++$zz){
				
				if((!Block::$solid[$level->getBlockIdAt($xx, $yyy, $zz)] || isset($this->overridable[$level->getBlockIdAt($xx, $yyy, $zz)])) && !(($xx == $x - 3 || $xx == $x + 3) && ($zz == $z - 3 || $zz == $z + 3))){
					$level->setBlockIdAt($xx, $yyy, $zz, $this->leafBlock);
					$level->setBlockDataAt($xx, $yyy, $zz, 14);
				}
			}
		}
	}
}