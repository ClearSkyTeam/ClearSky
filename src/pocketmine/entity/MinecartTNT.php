<?php

namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\item\Item as ItemItem;
use pocketmine\event\entity\EntityRegainHealthEvent;

class MinecartTNT extends Minecart{
	const NETWORK_ID = 97;
	public $height = 0.9;
	public $width = 1.1;
	public $drag = 0.1;
	public $gravity = 0.5;
	public $isMoving = false;
	public $moveSpeed = 0.4;
	public $isFreeMoving = false;
	public $isLinked = false;

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;
		$player->dataPacket($pk);
		Entity::spawnTo($player);
	}

	public function getName(){
		return "Minecart TNT";
	}

	public function getDrops(){
		return [ItemItem::get(ItemItem::MINECART, 0, 1),ItemItem::get(ItemItem::TNT, 0, 1)];
	}
	
	// TODO: Open inventory, add inventory, drop inventory contents
}
