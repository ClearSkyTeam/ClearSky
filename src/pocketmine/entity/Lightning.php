<?php
namespace pocketmine\entity;

use pocketmine\Player;

class Lightning extends Entity{
	const NETWORK_ID = 93;

	public $width = 0;
	public $length = 0;//TODO
	public $height = 0;

	public function initEntity(){
		parent::initEntity();
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;
		$player->dataPacket($pk);
		parent::spawnTo($player);
	}
}