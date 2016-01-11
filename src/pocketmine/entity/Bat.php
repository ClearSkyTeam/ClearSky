<?php
namespace pocketmine\entity;

use pocketmine\item\Item as Dr;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\Player;
use pocketmine\network\Network;
use pocketmine\network\protocol\MovePlayerPacket;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;


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
	}

	public function getName(){
		return "Bat";
	}

	 public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = Bat::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}

}
