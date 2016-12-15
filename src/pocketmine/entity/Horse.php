<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\Player;

class Horse extends Animal implements Rideable{
    const NETWORK_ID = 23;

    public $width = 0.75;
    public $height = 1.562;
    public $length = 1.5;//TODO
	
	protected $exp_min = 1;
	protected $exp_max = 3;//TODO

    public function initEntity(){
    	$this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_SADDLED, true, self::DATA_TYPE_BYTE);
    	$this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_TAMED, true, self::DATA_TYPE_BYTE);
    	$this->setDataProperty(self::DATA_BOUNDING_BOX_HEIGHT, self::DATA_TYPE_FLOAT, $this->height);
    	$this->setDataProperty(self::DATA_BOUNDING_BOX_WIDTH, self::DATA_TYPE_FLOAT, $this->length);
    	$this->setMaxHealth(10);//TODO
        parent::initEntity();
    }

    public function getName(){
        return "Horse";//TODO: Name by type
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
    
    public function canBeLeashed() {
    	return true; //TODO: distance check, already leashed check
    }
}
