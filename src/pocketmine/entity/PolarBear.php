<?php
namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\item\Item as ItemItem;
use pocketmine\Player;

class PolarBear extends Monster{
	const NETWORK_ID = 28;

	public $width = 1.031;
	public $length = 0.891;
	public $height = 2;
	
	protected $exp_min = 1;
	protected $exp_max = 3;

	public function initEntity(){
		$this->setMaxHealth(30);
		parent::initEntity();
	}

	public function getName(){
		return "Polar Bear";
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}

	public function getDrops(){
		$drops = [mt_rand(0, 3) == 0?ItemItem::get(ItemItem::RAW_FISH):ItemItem::get(ItemItem::RAW_SALMON)];
		
		return $drops;
	}
}
