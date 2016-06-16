<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\item\Item as ItemItem;
use pocketmine\nbt\tag\IntTag;

class Enderman extends Monster{
	const NETWORK_ID = 38;

	public $height = 2.875;
	public $width = 1.094;
	public $lenght = 0.5;
	
	protected $exp_min = 5;
	protected $exp_max = 5;

	public function initEntity(){
		$this->setMaxHealth(40);
		parent::initEntity();
		#for($i = 10; $i < 25; $i++){
		#	$this->setDataProperty($i, self::DATA_TYPE_BYTE, 1);
		#}
		if(!isset($this->namedtag->Angry)){
			$this->setAngry(false);
		}
	}

	public function getName(){
		return "Enderman";
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = Enderman::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}

	/*public function getDrops(){
		return [
			ItemItem::get(ItemItem::ENDERPEARL, 0, mt_rand(0, 1))
			// holding Block
		];
	}*/
	
	public function setAngry($angry = true){
		$this->namedtag->Angry = new IntTag("Angry", $angry);
		$this->setDataProperty(18, self::DATA_TYPE_BYTE, $angry);
	}

	public function getAngry(){
		return $this->namedtag["Angry"];
	}

}
