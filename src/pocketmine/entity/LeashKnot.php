<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\nbt\tag\CompoundTag;

class LeashKnot extends Entity{
	const NETWORK_ID = 88;

	public $width = 0.1;
	public $length = 0.1;//TODO
	public $height = 0.1;

	public function initEntity(){
		parent::initEntity();
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;
		//TODO LEASH ENTITY
		$player->dataPacket($pk);
		parent::spawnTo($player);
	}
	
	public function numberofAnimalsAttached(){}
	public function isPickable(){}
	public function removeAnimals(Player $player){}
	public function interactWithPlayer(Player $player){}
	public function addAdditionalSaveData(CompoundTag $compound){}
	public function readAdditionalSaveData(CompoundTag $compound){}
	public function recalculateBoundingBox(){}
	public function shouldRenderAtSqrDistance(){}
	public function remove(){}
	public function setDir(int $dir){}
	public function dropItem(){}
	public function getWidth(){}
	public function survives(){}
	public function getHeight(){}
	public function getEyeHeight(){}
	
}