<?php
namespace pocketmine\entity;

use pocketmine\item\Item as ItemItem;
use pocketmine\Player;
use pocketmine\event\entity\EntityDamageEvent;

class Guardian extends WaterAnimal implements Ageable{
	const NETWORK_ID = 49;

	public $width = 0.75;
	public $length = 0.75;
	public $height = 1;
	
	protected $exp_min = 10;
	protected $exp_max = 10;

	public function initEntity(){
		$this->setMaxHealth(30);
		parent::initEntity();
	}

	public function getName(){
		return "Guardian";
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}

    public function getDrops(){
		$drops = [ItemItem::get(ItemItem::PRISMARINE_SHARD, 0, mt_rand(0, 2))];
		
		if($this->getLastDamageCause() === EntityDamageEvent::CAUSE_FIRE){
			$drops[] = ItemItem::get(ItemItem::COOKED_FISH, 0, mt_rand(0, 100) < 40?1:0);
		}
		else{
			$drops[] = ItemItem::get(ItemItem::RAW_FISH, 0, mt_rand(0, 100) < 40?1:0);
		}
		
		$drops[] = ItemItem::get(ItemItem::PRISMARINE_CRYSTAL, 0, mt_rand(0, 100) < 40?1:0);
		
		return $drops;
	}
	
	public function isLeashableType(){
		return false;
	}
}
