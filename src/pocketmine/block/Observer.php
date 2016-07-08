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

	protected $currentStatus = [self::STATUS_IS_ACTIVATED => false, self::STATUS_ACTIVATED_TIMER => -1];

	const STATUS_IS_ACTIVATED = 0;
	const STATUS_ACTIVATED_TIMER = 1;
	const TICKS_ACTIVATED = 5;

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

	public function getWatchBlock(){
		return $this->getSide(Vector3::getOppositeSide($this->meta));
	}

	public function getOutputBlock(){
		return $this->getSide($this->meta);
	}

	public function isRedstoneSource(){
		return true;
	}

	public function isCharged($hash){
		if($this->getPower() == Block::REDSTONESOURCEPOWER && $this->getWatchBlock()->getHash() == $hash){
			return true;
		}
		return false;
	}

	public function getPower(){
		if($this->currentStatus[self::STATUS_IS_ACTIVATED]){
			return Block::REDSTONESOURCEPOWER;
		}
		return 0;
	}

	public function onUpdate($type){
		if($type == Level::BLOCK_UPDATE_NORMAL){
			$this->onUpdateRecieve(true); #TODO::getTheBlockWichCausedTheUpdate
		}
		if($type === Level::BLOCK_UPDATE_SCHEDULED){
			if($this->currentStatus[self::STATUS_IS_ACTIVATED] == true){
				if($this->currentStatus[self::STATUS_ACTIVATED_TIMER] >= self::TICKS_ACTIVATED){
					$this->currentStatus[self::STATUS_IS_ACTIVATED] = false;
					$this->getLevel()->setRedstoneUpdate($this->getOutputBlock(),Block::REDSTONEDELAY,Level::REDSTONE_UPDATE_BREAK,Block::REDSTONESOURCEPOWER);
				}else{
					$this->currentStatus[self::STATUS_ACTIVATED_TIMER]++;
					$this->getLevel()->scheduleUpdate($this, 1);
				}
			}
		}
	}

	public function onRedstoneUpdate($type,$power){
		$this->onUpdateAround(true); #TODO::getTheBlockWichCausedTheUpdate
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$this->meta = Vector3::getOppositeSide($face);
		$this->getLevel()->setBlock($block, $this, true, true);
		return true;
	}

	public function onUpdateRecieve($block){
		if($block == $this->getWatchBlock() || $block == true){
			$this->getLevel()->setRedstoneUpdate($this->getOutputBlock(),Block::REDSTONEDELAY,Level::REDSTONE_UPDATE_PLACE,Block::REDSTONESOURCEPOWER);
			$this->currentStatus[self::STATUS_IS_ACTIVATED] = true;
			$this->currentStatus[self::STATUS_ACTIVATED_TIMER] = 0;
			$this->getLevel()->scheduleUpdate($this, 1);
		}
	}
}