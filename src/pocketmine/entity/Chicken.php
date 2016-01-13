<?php
namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item as drp;
use pocketmine\Player;

class Chicken extends Animal{
	const NETWORK_ID = 10;

	public $width = 1;
	public $length = 0.5;
	public $height = 0.8;
	
	protected $exp_min = 1;
	protected $exp_max = 3;

	public function initEntity(){
		$this->setMaxHealth(4);
		parent::initEntity();
	}

	public function getName() {
		return "Chicken";
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}
	
	public function getDrops(){
		$drops = [drp::get(drp::FEATHER, 0, mt_rand(0, 2))];

		if($this->getLastDamageCause() === EntityDamageEvent::CAUSE_FIRE){
			$drops[] = drp::get(drp::COOKED_CHICKEN, 0, mt_rand(1, 2));
		}else{
			$drops[] = drp::get(drp::RAW_CHICKEN, 0, mt_rand(1, 2));
		}
		return $drops;
	}
}
