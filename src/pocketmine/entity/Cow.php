<?php
namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item as drp;
use pocketmine\Player;

class Cow extends Animal{
    const NETWORK_ID = 11;

    public $width = 0.75;
    public $height = 1.562;
    public $lenght = 1.5;
	
	protected $exp_min = 1;
	protected $exp_max = 3;

    public function initEntity(){
        $this->setMaxHealth(10);
        parent::initEntity();
    }

    public function getName(){
        return "Cow";
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
            drp::get(drp::LEATHER, 0, mt_rand(0, 2))
        ];

        if($this->getLastDamageCause() === EntityDamageEvent::CAUSE_FIRE){
            $drops[] = drp::get(drp::COOKED_BEEF, 0, mt_rand(1, 3));
        }else{
            $drops[] = drp::get(drp::RAW_BEEF, 0, mt_rand(1, 3));
        }

        return $drops;
    }
}
