<?php
namespace pocketmine\entity;


use pocketmine\Player;

class ChargedCreeper extends Creeper{

    public function initEntity(){
        $this->setMaxHealth(20);
        parent::initEntity();
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = Creeper::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function getName(){
        return "Charged Creeper";
    }

}