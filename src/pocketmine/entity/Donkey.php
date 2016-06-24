<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\Player;

class Donkey extends Animal implements Rideable{
    const NETWORK_ID = 24;

    public $width = 0.75;
    public $height = 1.562;
    public $lenght = 1.5;//TODO
	
	protected $exp_min = 1;
	protected $exp_max = 3;//TODO

    public function initEntity(){
        $this->setMaxHealth(10);//TODO
        parent::initEntity();
    }

    public function getName(){
        return "Donkey";//TODO: Name by type
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = self::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function isBaby(){
        return $this->getDataFlag(self::DATA_AGEABLE_FLAGS, self::DATA_FLAG_BABY);
    }

    public function getDrops(){
        $drops = [
            ItemItem::get(ItemItem::LEATHER, 0, mt_rand(0, 2))
        ];

        return $drops;
    }
}
