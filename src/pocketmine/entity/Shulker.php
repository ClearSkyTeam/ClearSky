<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\Player;

class Shulker extends Monster{
	const NETWORK_ID = 54;

	public $width = 1;
	public $length = 1;
	public $height = 1;
	
	protected $exp_min = 5;
	protected $exp_max = 5;

	public function initEntity(){
		$this->setMaxHealth(30);
		parent::initEntity();
	}

	public function getName(){
		return "Shulker";
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}

	public function getDrops(){
		/*$drops = [
			ItemItem::get(ItemItem::SHULKER_SHELL, 0, 1)
		];*/
		$drops = [];

		return $drops;
	}
}
