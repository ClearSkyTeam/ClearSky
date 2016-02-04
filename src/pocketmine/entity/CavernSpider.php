<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\Player;

class CavernSpider extends Monster{
	const NETWORK_ID = 40;

	public $width = 1.438;
	public $length = 1.188;
	public $height = 0.547;
	
	protected $exp_min = 5;
	protected $exp_max = 5;

	public function initEntity(){
		$this->setMaxHealth(12);
		parent::initEntity();
	}

	public function getName(){
		return "Cave Spider";
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}

	public function getDrops(){
		return[
			ItemItem::get(ItemItem::STRING, 0, mt_rand(0, 2)),
			ItemItem::get(ItemItem::SPIDER_EYE, 0, mt_rand(0, 1))
		];
	 }
  	
}
