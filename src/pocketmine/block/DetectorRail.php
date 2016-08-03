<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\level\Level;
use pocketmine\entity\Entity;
use pocketmine\entity\Minecart;

class DetectorRail extends Rail implements RedstoneConsumer{
	protected $id = self::DETECTOR_RAIL;
	const SIDE_NORTH_WEST = 6;
	const SIDE_NORTH_EAST = 7;
	const SIDE_SOUTH_EAST = 8;
	const SIDE_SOUTH_WEST = 9;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Detector Rail";
	}

	public function getHardness(){
		return 0.1;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_SCHEDULED){
			if($this->meta === 1 && !$this->isEntityCollided()){
				$this->meta = 0;
				$this->getLevel()->setBlock($this, Block::get($this->getId(), $this->meta), false, true);
				return Level::BLOCK_UPDATE_WEAK;
			}
		}
		if($type === Level::BLOCK_UPDATE_NORMAL){
			$this->getLevel()->scheduleUpdate($this, 50);
		}
		return false;
	}

	public function onEntityCollide(Entity $entity){
		if(!$this->isPowered()){
			$this->togglePowered();
		}
	}

	public function getDrops(Item $item){
		return [[Item::DETECTOR_RAIL,0,1]];
	}

	public function isPowered(){
		return (($this->meta & 0x01) === 0x01);
	}

	public function isEntityCollided(){
		foreach($this->getLevel()->getEntities() as $entity){
			if($entity instanceof Minecart && $this->getLevel()->getBlock($entity->getPosition()) === $this) return true;
		}
		return false;
	}

	/**
	 * Toggles the current state of this plate
	 */
	public function togglePowered(){
		$this->meta ^= 0x08;
		$this->isPowered()?$this->power = 15:$this->power = 0;
		$this->getLevel()->setBlock($this, $this, true, true);
	}
}