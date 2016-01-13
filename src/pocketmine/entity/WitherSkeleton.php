<?php
namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\item\Item as ItemItem;
use pocketmine\Player;

class WitherSkeleton extends Skeleton{
    public $height = 2.39;
    public $width = 0.938;
    public $lenght = 1.312;
	
	protected $exp_min = 5;
	protected $exp_max = 5;

    public function initEntity(){
        $this->setMaxHealth(20);
        parent::initEntity();
    }

    public function getName(){
        return "Wither Skeleton";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = Skeleton::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function getDrops(){
        $drops = [];
        if($this->lastDamageCause instanceof EntityDamageByEntityEvent and $this->lastDamageCause->getEntity() instanceof Player){
            $drops = [
                ItemItem::get(ItemItem::COAL, 0, mt_rand(0, 1)),
                ItemItem::get(ItemItem::BONE, 0, mt_rand(0, 2))
            ];
        }

        if($this->lastDamageCause instanceof EntityDamageByEntityEvent and $this->lastDamageCause->getEntity() instanceof ChargedCreeper){
            $drops = [
                ItemItem::get(ItemItem::SKULL, 1, 1)
            ];
        }

        return $drops;
    }


}