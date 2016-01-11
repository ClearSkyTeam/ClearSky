<?php
namespace pocketmine\level\generator\object;

use pocketmine\block\Block;
use pocketmine\block\Wood;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;

class BirchTree extends Tree{

	protected $superBirch = false;

	public function __construct($superBirch = false){
		$this->trunkBlock = Block::LOG;
		$this->leafBlock = Block::LEAVES;
		$this->type = Wood::BIRCH;
		$this->superBirch = (bool) $superBirch;
	}

	public function placeObject(ChunkManager $level, $x, $y, $z, Random $random){
		$this->treeHeight = $random->nextBoundedInt(3) + 5;
		if($this->superBirch){
			$this->treeHeight += 5;
		}
		parent::placeObject($level, $x, $y, $z, $random);
	}
}