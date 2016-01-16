<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\Player;

class Slime extends Living{
    const NETWORK_ID = 37;

    const DATA_SIZE = 16;

    public $height = 2;
    public $width = 2;
    public $lenght = 2;
	
	protected $exp_min = 1;
	protected $exp_max = 1;//TODO: Size

    public function initEntity(){
        $this->setMaxHealth(16);
        parent::initEntity();
    }

    public function getName(){
        return "Slime";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = Slime::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function getDrops(){
        return [
            ItemItem::get(ItemItem::SLIMEBALL, 0, mt_rand(0, 2))
        ];
    }



}
