<?php
namespace pocketmine\entity;

use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;

class ThrownExpBottle extends Projectile{
	const NETWORK_ID = 68;

	public $width = 0.25;
	public $length = 0.25;
	public $height = 0.25;
	
	protected $gravity = 0.1;
	protected $drag = 0.05;

	public function __construct(FullChunk $chunk, CompoundTag $nbt, Entity $shootingEntity = null){
		parent::__construct($chunk, $nbt, $shootingEntity);
	}

	public function getName(){
		return "Thrown Exp Bottle";
	}

	public function onUpdate($currentTick){
		if($this->closed){
			return false;
		}

		$this->timings->startTiming();

		$hasUpdate = parent::onUpdate($currentTick);

		if($this->age > 1200 or $this->isCollided){
			$this->kill();
			$this->close();
			$hasUpdate = true;
		}
		
		if($this->onGround){
			$this->kill();
			$this->close();
			$this->getLevel()->spawnExperienceOrb($this->add(0,1,0), mt_rand(3,11));
		}

		$this->timings->stopTiming();

		return $hasUpdate;
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;
		
		$player->dataPacket($pk);
		parent::spawnTo($player);
	}
}