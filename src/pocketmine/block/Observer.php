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
		if($this->getPower() == Block::REDSTONESOURCEPOWER && $this->getOutputBlock()->getHash() == $hash){
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

	public function onUpdate($type, $fromBlock = NULL){
		if($type == Level::BLOCK_UPDATE_NORMAL){
			if($fromBlock != NULL){
				echo("onUpdate");
				$this->onUpdateRecieve(self::TYPE_BLOCK_OBJECT, $fromBlock);
			}
		}
		if($type === Level::BLOCK_UPDATE_SCHEDULED){
			if($this->currentStatus[self::STATUS_IS_ACTIVATED]){
				if($this->currentStatus[self::STATUS_ACTIVATED_TIMER] >= self::TICKS_ACTIVATED){
					$this->currentStatus[self::STATUS_IS_ACTIVATED] = false;
					$this->getLevel()->setRedstoneUpdate($this->getOutputBlock(),Block::REDSTONEDELAY,Level::REDSTONE_UPDATE_BREAK,Block::REDSTONESOURCEPOWER);
					$this->getLevel()->setRedstoneUpdate($this->getOutputBlock(),Block::REDSTONEDELAY,Level::REDSTONE_UPDATE_BLOCK,0);
				}else{
					$this->currentStatus[self::STATUS_ACTIVATED_TIMER]++;
					for($side = 0; $side <= 5; $side++){
						$block = $this->getSide($side);
						if($block != $this->getOutputBlock){
							$this->getLevel()->setRedstoneUpdate($block,Block::REDSTONEDELAY,Level::REDSTONE_UPDATE_BREAK,Block::REDSTONESOURCEPOWER);
						}
					}
					$this->getLevel()->scheduleUpdate($this, 1);
				}
			}
		}
	}

	public function onRedstoneUpdate($type,$power,$hash = NULL){
		if($hash != NULL){
			echo("onRedstoneUpdate");
			$this->onUpdateRecieve(self::TYPE_BLOCK_HASH, $hash);
		}
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$this->meta = Vector3::getOppositeSide($face);
		$this->getLevel()->setBlock($block, $this, true, true);
		$this->getLevel()->setBlockIdAt($this->getWatchBlock()->x,$this->getWatchBlock()->y,$this->getWatchBlock()->z, 1);
		$this->getLevel()->setBlockIdAt($this->getOutputBlock()->x,$this->getOutputBlock()->y,$this->getOutputBlock()->z, 2);
		return true;
	}

	private function onUpdateRecieve($type = NULL, $data = NULL){
		if($type === self::TYPE_BLOCK_HASH && ($data != $this->getWatchBlock()->getHash())){
			var_dump($data);
			var_dump($this->getWatchBlock()->getHash());
			echo("nope\n");
			return;
		}
		if($type === self::TYPE_BLOCK_OBJECT && ([$data->x, $data->y, $data->z] != [$this->getWatchBlock()->x, $this->getWatchBlock()->y, $this->getWatchBlock()->z])){
			echo("nope\n");
			return;
		}
		$this->getLevel()->setRedstoneUpdate($this->getOutputBlock(),Block::REDSTONEDELAY,Level::REDSTONE_UPDATE_PLACE,Block::REDSTONESOURCEPOWER);
		$this->currentStatus[self::STATUS_IS_ACTIVATED] = true;
		$this->currentStatus[self::STATUS_ACTIVATED_TIMER] = 0;
		$this->getLevel()->scheduleUpdate($this, 1);
	}
}