<?php
namespace pocketmine\entity;


use pocketmine\nbt\tag\IntTag;
use pocketmine\Player;

class Villager extends Creature implements NPC, Ageable{
	const NETWORK_ID = 15;

	const PROFESSION_FARMER = 0;
	const PROFESSION_LIBRARIAN = 1;
	const PROFESSION_PRIEST = 2;
	const PROFESSION_BLACKSMITH = 3;
	const PROFESSION_BUTCHER = 4;
	const PROFESSION_GENERIC = 5;//will crash client!

	public $width = 0.938;
	public $length = 0.609;
	public $height = 2;
	
	protected $exp_min = 0;
	protected $exp_max = 0;

	public function getName(){
		return "Villager";
	}

	protected function initEntity(){
		$this->setMaxHealth(20);
		parent::initEntity();

		if(!isset($this->namedtag->Profession) || $this->getVariant() > 4){
			$this->setVariant(mt_rand(0, 4));
		}
		$this->setDataProperty(16, self::DATA_TYPE_BYTE, $this->getVariant());
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = Villager::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}

	/**
	 * Sets the villager profession
	 *
	 * @param $profession
	 */
	public function setVariant($type){
		$this->namedtag->Profession = new Int("Profession", $type);
		$this->setDataProperty(16, self::DATA_TYPE_BYTE, $type);
	}

	public function getVariant(){
		return $this->namedtag["Profession"];
	}

	public function isBaby(){
		return $this->getDataFlag(self::DATA_AGEABLE_FLAGS, self::DATA_FLAG_BABY);
	}
}
