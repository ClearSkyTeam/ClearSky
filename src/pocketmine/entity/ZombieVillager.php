<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\nbt\tag\IntTag;

class ZombieVillager extends Zombie{
	const NETWORK_ID = 44;
	
	public $width = 1.031;
	public $length = 0.891;
	public $height = 2.125;

	public function initEntity(){
		$this->setMaxHealth(20);
		parent::initEntity();
		if(!isset($this->namedtag->Profession) || $this->getVariant() > 4){
			$this->setVariant(mt_rand(0, 4));
		}
		$this->setDataProperty(16, self::DATA_TYPE_BYTE, $this->getVariant());
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

	/**
	 * Sets the zombievillager profession
	 *
	 * @param $profession
	 */
	public function setVariant($type){
		$this->namedtag->Profession = new IntTag("Profession", $type);
		$this->setDataProperty(16, self::DATA_TYPE_BYTE, $type);
	}

	public function getVariant(){
		return $this->namedtag["Profession"];
	}

}
