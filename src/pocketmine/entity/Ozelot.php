<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\nbt\tag\IntTag;

class Ozelot extends Animal implements Tameable{
	const NETWORK_ID = 22;
	
	const TYPE_NORMAL = 0;
	const TYPE_BLACK = 1;
	const TYPE_ORANGE = 2;
	const TYPE_SIAMESE = 3;

	public $width = 0.312;
	public $length = 2.188;
	public $height = 0.75;
	
	protected $exp_min = 1;
	protected $exp_max = 3;

 	public static $range = 10;
	public static $speed = 0.8;
	public static $jump = 1;
	public static $mindist = 10;

	public function initEntity(){
		$this->setMaxHealth(10);
		parent::initEntity();

		//0 burning
		//1 air time
		//5 invis
		//14 age (0=baby 130000 = parent)
		//15 no movement
		//16 sheep color
		//18 type/variant
		//19 creeper charged
		//21 love

        if(!isset($this->namedtag->Type) || $this->getVariant() > 3){
            $this->setVariant(self::TYPE_NORMAL);
        }
		$this->setDataProperty(16, self::DATA_TYPE_BYTE, $this->getVariant());
	}

	public function getName(){
		return "Ocelot";
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = Ozelot::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}

	public function getDrops(){
		return [];
	}
	
	public function isTamed(){
		return false;
	}

    public function setVariant($value){
        $this->namedtag->Color = new Int("Type", $value);
		$this->setDataProperty(16, self::DATA_TYPE_BYTE, $value);
    }

    public function getVariant(){
        return $this->namedtag["Type"];
    }
}
