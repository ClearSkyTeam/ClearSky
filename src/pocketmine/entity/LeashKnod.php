<?php
namespace pocketmine\entity;

use pocketmine\Player;

class LeashKnod extends Entity{
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
}