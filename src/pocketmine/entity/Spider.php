<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\Player;

class Spider extends Monster{
    const NETWORK_ID = 35;

    public $width = 2.062;
    public $length = 1.703;
    public $height = 0.781;
	
	protected $exp_min = 5;
	protected $exp_max = 5;

    public function initEntity(){
        $this->setMaxHealth(16);
        parent::initEntity();
    }

    public function getName(){
        return "Spider";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = Spider::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function getDrops(){
        return[
            [ItemItem::get(ItemItem::STRING, 0, mt_rand(0, 2))],
            [ItemItem::get(ItemItem::SPIDER_EYE, 0, mt_rand(0, 1))]
        ];
    }
}
