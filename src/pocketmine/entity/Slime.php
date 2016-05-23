<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\Player;
use pocketmine\nbt\tag\IntTag;

class Slime extends Living{
    const NETWORK_ID = 37;
    const DATA_SIZE = 16;

    public $height = 2;
    public $width = 2;
    public $lenght = 2;//TODO: Size
	
	protected $exp_min = 1;
	protected $exp_max = 1;//TODO: Size

    public function initEntity(){
        $this->setMaxHealth(16);
        parent::initEntity();
		if(!isset($this->namedtag->Size)){
			$this->setSize(mt_rand(0, 3));
		}
    }

    public function getName(){
        return "Slime";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = self::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function getDrops(){
        return [
            ItemItem::get(ItemItem::SLIMEBALL, 0, mt_rand(0, 2))
        ];
    }

    public function setSize($value){
        $this->namedtag->Size = new IntTag("Size", $value);
		$this->setDataProperty(self::DATA_SIZE, self::DATA_TYPE_BYTE, $value);
    }

    public function getSize(){
        return $this->namedtag["Size"];
    }

}
