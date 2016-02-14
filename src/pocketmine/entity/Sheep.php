<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\Player;
use pocketmine\nbt\tag\Int;

class Sheep extends Animal implements Colorable{
    const NETWORK_ID = 13;

    public $lenght = 1.484;
    public $width = 0.719;
    public $height = 1.406;
	
	protected $exp_min = 1;
	protected $exp_max = 3;

    public function initEntity(){
        $this->setMaxHealth(8);
        parent::initEntity();

        if(!isset($this->namedtag->Color)){
            $this->setColor(0);
        }
    }

    public function getName(){
        return "Sheep";
    }

    public function spawnTo(Player $player){
        $pk = $this->addEntityDataPacket($player);
        $pk->type = Sheep::NETWORK_ID;

        $player->dataPacket($pk);
        parent::spawnTo($player);
    }

    public function setColor($value){
        $this->namedtag->Color = new Int("Color", $value);
		$this->setDataProperty(16, self::DATA_TYPE_BYTE, $value);
    }

    public function getColor(){
        return $this->namedtag["Color"];
    }

    public function getDrops(){
        return[
            ItemItem::get(ItemItem::WOOL, $this->getColor(), 1)
        ];
    }
}