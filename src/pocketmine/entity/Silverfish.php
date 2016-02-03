<?php
namespace pocketmine\entity;

use pocketmine\Player;

class Silverfish extends Monster{
    const NETWORK_ID = 39;

    public $height = 0.438;
    public $width = 0.609;
    public $lenght = 1.094;
	
	protected $exp_min = 5;
	protected $exp_max = 5;

    public function initEntity(){
        $this->setMaxHealth(8);
        parent::initEntity();
    }

 	public function getName(){
        return "Silverfish";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = Silverfish::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function getDrops(){
        return [];
    }
}
