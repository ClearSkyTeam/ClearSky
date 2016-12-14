<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\level\Explosion;

class EnderCrystal extends Entity implements Explosive{
	const NETWORK_ID = 62;

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
		return "Ender Crystal";
	}

	public function kill(){
		if(!$this->isAlive()){
			return;
		}
		$this->explode();
		parent::kill();
		if(!$this->closed){
			$this->close();
		}
	}

	public function explode(){
		$this->server->getPluginManager()->callEvent($ev = new ExplosionPrimeEvent($this, 6));

		if(!$ev->isCancelled()){
			$explosion = new Explosion($this, $ev->getForce(), $this);
			if($ev->isBlockBreaking()){
				$explosion->explodeA();
			}
			$explosion->explodeB();
		}
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}
}
