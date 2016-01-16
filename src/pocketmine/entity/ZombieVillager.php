<?php
namespace pocketmine\entity;

use pocketmine\Player;

class ZombieVillager extends Zombie{
	const NETWORK_ID = 44;
	
	public $width = 1.031;
	public $length = 0.891;
	public $height = 2.125;

	public function initEntity(){
		$this->setMaxHealth(20);
		parent::initEntity();
	}

	public function getName(){
		return "Zombie Villager";
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = ZombieVillager::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}

}
