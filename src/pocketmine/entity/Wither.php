<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\Player;

class Wither extends Monster implements ProjectileSource{
    const NETWORK_ID = 52;

    public $height = 2;
    public $width = 3;
    public $lenght = 1;//TODO: check
	
	protected $exp_min = 20;
	protected $exp_max = 20;

    public function initEntity(){
        $this->setMaxHealth(600);
        parent::initEntity();
    }

 	public function getName(){
        return "Wither Boss";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = self::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function getDrops(){
		return [ItemItem::get(ItemItem::NETHER_STAR)];
    }
}
