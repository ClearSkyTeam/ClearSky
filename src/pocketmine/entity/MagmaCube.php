<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\Player;
use pocketmine\nbt\tag\Int;

class MagmaCube extends Living{
	const NETWORK_ID = 42;
    const DATA_SIZE = 16;

	public $width = 2;
	public $length = 2;
	public $height = 2;//TODO: Size
	
	protected $exp_min = 1;
	protected $exp_max = 1; //TODO: Size

	public function initEntity(){
		$this->setMaxHealth(1); //TODO Size
		parent::initEntity();
		if(!isset($this->namedtag->Size)){
			$this->setSize(mt_rand(0, 3));
		}
	}

	public function getName(){
		return "Magma Cube";
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = MagmaCube::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}
	
	//TODO: Stop lava/fire damage

	public function getDrops(){
		return [
			ItemItem::get(ItemItem::MAGMA_CREAM, 0, mt_rand(0, 2))
		];
	}

    public function setSize($value){
        $this->namedtag->Size = new Int("Size", $value);
		$this->setDataProperty(self::DATA_SIZE, self::DATA_TYPE_BYTE, $value);
    }

    public function getSize(){
        return $this->namedtag["Size"];
    }
}
