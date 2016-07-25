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

	protected $currentStatus = self::STATUS_IS_DEACTIVATED;

	const STATUS_IS_DEACTIVATED = -1;
	const STATUS_QUED_FOR_DEACTIVATION = 0;
	const STATUS_IS_ACTIVATED = 1;

	const TYPE_BLOCK_HASH = 0;
	const TYPE_BLOCK_OBJECT = 1; #Vector3/Position/Block instance

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
		if($this->currentStatus != self::STATUS_IS_DEACTIVATED && $this->getOutputBlock()->getHash() == $hash){
			return true;
		}
		return false;
	}

	public function getPower(){
		return 0;
	}

	public function onUpdate($type, $fromBlock = NULL){
		if($type == Level::BLOCK_UPDATE_NORMAL){
			if($fromBlock != NULL){
				$this->onUpdateRecieve(self::TYPE_BLOCK_OBJECT, $fromBlock);
			}
		}
		if($type === Level::BLOCK_UPDATE_SCHEDULED){
			if($this->currentStatus != self::STATUS_IS_DEACTIVATED){
				if($this->currentStatus == self::STATUS_IS_ACTIVATED){
					$this->getLevel()->setRedstoneUpdate($this->getOutputBlock(),Block::REDSTONEDELAY,Level::REDSTONE_UPDATE_BLOCK,Block::REDSTONESOURCEPOWER);
					$this->currentStatus = self::STATUS_QUED_FOR_DEACTIVATION;
					$this->getLevel()->scheduleUpdate($this, 2);
				}elseif($this->currentStatus == self::STATUS_QUED_FOR_DEACTIVATION){
					$this->currentStatus = self::STATUS_IS_DEACTIVATED;
					$this->getLevel()->setRedstoneUpdate($this->getOutputBlock(),Block::REDSTONEDELAY,Level::REDSTONE_UPDATE_BLOCK,0);
				}		
			}
		}
	}

	public function onRedstoneUpdate($type,$power,$hash = NULL){
		if($hash != NULL){
			$this->onUpdateRecieve(self::TYPE_BLOCK_HASH, $hash);
		}
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$this->meta = Vector3::getOppositeSide($face);
		$this->getLevel()->setBlock($block, $this, true, true);
		return true;
	}

	private function onUpdateRecieve($type = NULL, $data = NULL){
		if($type === self::TYPE_BLOCK_HASH && ($data != $this->getWatchBlock()->getHash())){
			return;
		}
		if($type === self::TYPE_BLOCK_OBJECT && ([$data->x, $data->y, $data->z] != [$this->getWatchBlock()->x, $this->getWatchBlock()->y, $this->getWatchBlock()->z])){
			return;
		}
		$this->currentStatus = self::STATUS_IS_ACTIVATED;
		$this->getLevel()->setRedstoneUpdate($this->getOutputBlock(),Block::REDSTONEDELAY,Level::REDSTONE_UPDATE_PLACE,Block::REDSTONESOURCEPOWER);
		$this->getLevel()->scheduleUpdate($this, 1);
	}
}