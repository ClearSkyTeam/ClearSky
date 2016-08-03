<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\item\Item as ItemItem;
use pocketmine\event\entity\EntityRegainHealthEvent;

class MinecartChest extends Minecart{

     const NETWORK_ID = 98;

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;
		$player->dataPacket($pk);
		Entity::spawnTo($player);
	}

    public function getName(){
        return "Minecart Chest";
    }

    public function getDrops(){
        return [ItemItem::get(ItemItem::MINECART, 0, 1),ItemItem::get(ItemItem::CHEST, 0, 1)];
    }
    
    //TODO: Open inventory, add inventory, drop inventory contents
}
