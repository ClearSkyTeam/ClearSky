<?php
namespace pocketmine\entity;

use pocketmine\Player;

class Wolf extends Animal implements Tameable{
	const NETWORK_ID = 14;

	public $height = 0.969;
	public $width = 0.5;
	public $lenght = 1.594;
	
	protected $exp_min = 1;
	protected $exp_max = 3;

	public function initEntity(){
		$this->setMaxHealth(8); //Untamed
		parent::initEntity();
	}

	public function getName(){
		return "Wolf";
	}
	
	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = Wolf::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}
	
	public function isTamed(){
		return false;
	}
}
