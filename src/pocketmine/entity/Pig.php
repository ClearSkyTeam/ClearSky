<?php
namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item as ItemItem;
use pocketmine\Player;

class Pig extends Animal implements Rideable{
    const NETWORK_ID = 12;

    public $width = 0.625;
    public $height = 1;
    public $lenght = 1.5;
	
	protected $exp_min = 1;
	protected $exp_max = 3;

    public function initEntity(){
        $this->setMaxHealth(10);
        parent::initEntity();
    }

    public function getName() {
        return "Pig";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = Pig::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function isBaby(){
        return $this->getDataFlag(self::DATA_AGEABLE_FLAGS, self::DATA_FLAG_BABY);
    }

    public function getDrops(){
        $drops = [];
        if($this->getLastDamageCause() === EntityDamageEvent::CAUSE_FIRE){
            $drops[] = ItemItem::get(ItemItem::COOKED_PORKCHOP, 0, mt_rand(1, 3));
        }else{
            $drops[] = ItemItem::get(ItemItem::RAW_PORKCHOP, 0, mt_rand(1, 3));
        }
        return $drops;
    }
}
