<?php
namespace pocketmine\entity;

use pocketmine\Player;

class Witch extends Monster implements ProjectileSource{
    const NETWORK_ID = 45;

    public $width = 0.938;
    public $length = 0.609;
    public $height = 2;
	
	protected $exp_min = 5;
	protected $exp_max = 5;

    public function initEntity(){
        $this->setMaxHealth(20);
        parent::initEntity();
    }

 	public function getName(){
        return "Witch";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = self::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function getDrops(){
        $drops = []; //TODO: Drops
        return $drops;
    }
}
