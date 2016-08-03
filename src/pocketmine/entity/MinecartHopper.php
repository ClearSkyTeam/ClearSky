<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\item\Item as ItemItem;
use pocketmine\event\entity\EntityRegainHealthEvent;

class MinecartHopper extends Minecart{

     const NETWORK_ID = 96;

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;
		$player->dataPacket($pk);
		Entity::spawnTo($player);
	}

    public function getName(){
        return "Minecart Hopper";
    }

    public function getDrops(){
        return [ItemItem::get(ItemItem::MINECART, 0, 1),ItemItem::get(ItemItem::HOPPER, 0, 1)];
    }
    
    //TODO: Open inventory, add inventory, drop inventory contents
}
