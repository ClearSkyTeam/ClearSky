<?php
namespace pocketmine\level\generator\object;

use pocketmine\block\Block;
use pocketmine\block\Wood;

class JungleTree extends Tree{

	public function __construct(){
		$this->trunkBlock = Block::LOG;
		$this->leafBlock = Block::LEAVES;
		$this->type = Wood::JUNGLE;
		$this->treeHeight = 8;
	}
}