<?php
namespace pocketmine\entity;

use pocketmine\Player;

class Endermite extends Monster{
    const NETWORK_ID = 55;

    public $height = 0.438;
    public $width = 0.609;
    public $lenght = 1.094;
	
	protected $exp_min = 3;
	protected $exp_max = 3;

    public function initEntity(){
        $this->setMaxHealth(8);
        parent::initEntity();
    }

 	public function getName(){
        return "Endermite";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = self::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }
}
