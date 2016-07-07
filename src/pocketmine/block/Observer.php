<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\Player;
use pocketmine\math\Vector3;
use pocketmine\level\Level;
use pocketmine\event\block\BlockUpdateEvent;

class Observer extends Solid implements RedstoneSource{
	protected $id = Block::OBSERVER;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Observer";
	}

	public function getHardness(){
		return 3.5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function isRedstoneSource(){
		return true;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$this->meta = Vector3::getOppositeSide($face);
		$this->getLevel()->setBlock($block, $this, true, true);
		return true;
	}

	public function getUpdate(BlockUpdateEvent $event){
		if($event->isCancelled()) return;
		$watch = $this->getSide(Vector3::getOppositeSide($this->meta));
		if($event->getBlock() === $watch){
			$this->getSide($this->meta)->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_PLACE, 1);
		}
	}
}