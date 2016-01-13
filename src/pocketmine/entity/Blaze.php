<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\item\Item as drp;

class Blaze extends Monster{
	const NETWORK_ID = 43;

	public $height = 1.5;
	public $width = 1.25;
	public $lenght = 0.906;
	
	protected $exp_min = 10;
	protected $exp_max = 10;

	public function initEntity(){
		$this->setMaxHealth(20);
		parent::initEntity();
	}

	public function getName(){
		return "Blaze";
 	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}
	
	public function getDrops(){
		return [
			drp::get(drp::BLAZE_ROD, 0, mt_rand(0, 1))
		];
	}
}