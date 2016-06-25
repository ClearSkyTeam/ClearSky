<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\item\Item as ItemItem;

class SmallFireball extends Entity{
	const NETWORK_ID = 94;

	public $height = 1.5;
	public $width = 1.25;
	public $lenght = 0.906;//TODO

	public function initEntity(){
		$this->setMaxHealth(1);
		parent::initEntity();
	}

	public function getName(){
		return "SmallFireball";
 	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}
}