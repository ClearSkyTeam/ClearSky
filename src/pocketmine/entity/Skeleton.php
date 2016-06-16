<?php
namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityExplodeEvent;
use pocketmine\item\Item as ItemItem;
use pocketmine\nbt\tag\Int;
use pocketmine\Player;

class Skeleton extends Monster implements ProjectileSource{
    const NETWORK_ID = 34;

    public $height = 2;
    public $width = 0.781;
    public $lenght = 0.875;
	
	protected $exp_min = 5;
	protected $exp_max = 5;

    public function initEntity(){
        $this->setMaxHealth(20);
        parent::initEntity();

        if(!isset($this->namedtag->Profession)){
            $this->setSkeletonType(1);
        }
    }

 	public function getName(){
        return "Skeleton";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = self::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function setSkeletonType($type){
        $this->namedtag->SkeletonType = new Int("SkeletonType", $type);
    }

    public function getSkeletonType(){
        return $this->namedtag["SkeletonType"];
    }

    public function getDrops(){
        $drops = [
            ItemItem::get(ItemItem::ARROW, 0, mt_rand(0, 2)),
            ItemItem::get(ItemItem::BONE, 0, mt_rand(0, 2))
        ];

        if($this->lastDamageCause instanceof EntityDamageByEntityEvent and $this->lastDamageCause->getEntity() instanceof Player){
            if(mt_rand(0, 199) < 5){
                $drops[] = ItemItem::get(ItemItem::BOW, 0, 1);
            }
        }

        if($this->lastDamageCause instanceof EntityExplodeEvent and $this->lastDamageCause->getEntity() instanceof Creeper && $this->lastDamageCause->getEntity()->isPowered()){
            $drops[] = ItemItem::get(ItemItem::SKULL, 0, 1);
        }

        return $drops;
    }
}
