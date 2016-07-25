<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\Player;

class SnowGolem extends Animal{
    const NETWORK_ID = 21;

    public $height = 1.875;
    public $width = 1.281;
    public $lenght = 0.688;
	
	protected $exp_min = 0;
	protected $exp_max = 0;

    public function initEntity(){
        $this->setMaxHealth(4);
        parent::initEntity();
    }

    public function getName(){
        return "Snow Golem";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = self::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function getDrops(){
        return [
            ItemItem::get(ItemItem::SNOWBALL, 0, mt_rand(0, 15))
        ];
    }

    public function isLeashableType() {
    	return false;
    }
}