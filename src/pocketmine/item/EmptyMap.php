<?php

namespace pocketmine\item;

use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\block\Block;

class EmptyMap extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::EMPTY_MAP, $meta, $count, "Empty Map");
	}

	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$player->getInventory()->remove(Item::get($player->getInventory()->getItemInHand()->getId(), 0, 1));
		$player->getInventory()->addItem(Item::get(Item::WRITTEN_MAP));
	}
}