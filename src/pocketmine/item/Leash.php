<?php

namespace pocketmine\item;

use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\block\Block;
class Leash extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::LEAD, $meta, $count, "Leash");
	}
	
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
	}
}
