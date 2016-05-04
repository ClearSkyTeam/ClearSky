<?php

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\Fire;
use pocketmine\block\Solid;
use pocketmine\level\Level;
use pocketmine\Player;

class FlintSteel extends Tool{

	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Block::FIRE);
		parent::__construct(self::FLINT_STEEL, $meta, $count, "Flint and Steel");
	}

	public function canBeActivated(){
		return true;
	}

	/*
	 * public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
	 * if($block->canBeReplaced() and ($target instanceof Solid)){
	 * $level->setBlock($block, new Fire(), true);
	 * }
	 * }
	 */
	public function getMaxDurability(){
		return 65;
	}
}