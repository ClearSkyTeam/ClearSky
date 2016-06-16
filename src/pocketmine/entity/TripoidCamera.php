<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\Player;
use pocketmine\nbt\tag\IntTag;
use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\CompoundTag;

class TripoidCamera extends Snake{
    const NETWORK_ID = 95;

    public $height = 1;
    public $width = 1;
    public $lenght = 1;//TODO: Size
	
	public function __construct(FullChunk $chunk, CompoundTag $nbt){
		parent::__construct($chunk, $nbt);
	}

    public function initEntity(){
        $this->setMaxHealth(1);
        parent::initEntity();
    }

    public function getName(){
        return "Tripoid Camera";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = self::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function getDrops(){
        return [ItemItem::get(ItemItem::CAMERA, 0, 1)];
    }
}
