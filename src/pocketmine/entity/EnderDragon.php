<?php
namespace pocketmine\entity;

use pocketmine\Player;

class EnderDragon extends Monster implements ProjectileSource{
    const NETWORK_ID = 53;

    public $height = 2;
    public $width = 3;
    public $lenght = 1;//TODO: check
	
	protected $exp_min = 12500;
	protected $exp_max = 12500;

    public function initEntity(){
        $this->setMaxHealth(200);
        parent::initEntity();
    }

 	public function getName(){
        return "Ender Dragon";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = self::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }
}
