<?php
namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityExplodeEvent;
use pocketmine\item\Item as drp;
use pocketmine\nbt\tag\Int;
use pocketmine\Player;

class Creeper extends Monster implements Explosive{
    const NETWORK_ID = 33;
	
	protected $exp_min = 5;
	protected $exp_max = 5;

    public function initEntity(){
        $this->setMaxHealth(20);
        parent::initEntity();

        if(!isset($this->namedtag->Powered)){
            $this->setPowered(1);
        }
    }

    public function getName() {
        return "Creeper";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = self::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function explode(){
        //TODO: CreeperExplodeEvent
    }

    public function setPowered($value){
        $this->namedtag->Powered = new Int("Powered", $value);
    }

    public function isPowered(){
        return $this->namedtag["Powered"];
    }

    public function getDrops(){
        $drops = [];
        if($this->lastDamageCause instanceof EntityDamageByEntityEvent and $this->lastDamageCause->getEntity() instanceof Player){
            $drops = [
                drp::get(drp::GUNPOWDER, 0, mt_rand(0, 2))
            ];
        }

        if($this->lastDamageCause instanceof EntityExplodeEvent and $this->lastDamageCause->getEntity() instanceof ChargedCreeper){
            $drops = [
                drp::get(drp::SKULL, 4, 1)
            ];
        }

        return $drops;
    }
}
