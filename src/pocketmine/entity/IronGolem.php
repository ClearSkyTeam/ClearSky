<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\Player;

class IronGolem extends Animal{
    const NETWORK_ID = 20;

    public $height = 2.688;
    public $width = 1.625;
    public $lenght = 0.906;

    public function initEntity(){
        $this->setMaxHealth(100);
        parent::initEntity();
    }

    public function getName(){
        return "Iron Golem";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = self::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function getDrops(){
        return [
            ItemItem::get(ItemItem::IRON_INGOT, 0, mt_rand(3, 5)),
            ItemItem::get(ItemItem::POPPY, 0, mt_rand(0, 2))
        ];
    }

}