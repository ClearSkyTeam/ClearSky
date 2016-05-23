<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\nbt\tag\IntTag;

class Bat extends Animal{
	const NETWORK_ID = 19;

	public $width = 0.469;
	public $length = 0.484;
	public $height = 0.5;

	public static $range = 16;
	public static $speed = 0.25;
	public static $jump = 1.8;
	public static $mindist = 3;

	public function initEntity(){
		$this->setMaxHealth(6);
		parent::initEntity();
		/*for($i = 1; $i < 40; $i++){
			$this->setDataProperty($i, self::DATA_TYPE_BYTE, 1);
		}*/
	}

	public function getName(){
		return "Bat";
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}
	
	public function setVariant($type){
		$this->namedtag->Variant = new IntTag("Variant", $type);
		$this->setDataProperty(16, self::DATA_TYPE_BYTE, $type);
	}

	public function getVariant(){
		return $this->namedtag["Variant"];
	}

}
