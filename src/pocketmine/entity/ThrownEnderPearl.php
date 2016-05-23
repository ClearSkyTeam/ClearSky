<?php
namespace pocketmine\entity;

use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;

class ThrownEnderPearl extends Projectile{
	const NETWORK_ID = 87;

	public $width = 0.25;
	public $length = 0.25;
	public $height = 0.25;

	protected $gravity = 0.03;
	protected $drag = 0.01;

	public function __construct(FullChunk $chunk, Compound $nbt, Entity $shootingEntity = null){
		parent::__construct($chunk, $nbt, $shootingEntity);
	}

	public function onUpdate($currentTick){
		if($this->closed){
			return false;
		}

		$this->timings->startTiming();

		$hasUpdate = parent::onUpdate($currentTick);

		if($this->age > 1200 or $this->isCollided){
			if($this->isCollided && $this->shootingEntity !== null && $this->shootingEntity instanceof Player){
				if($this->getLevel()->getServer()->getPlayer($this->shootingEntity->getName())->isOnline()){
					$this->shootingEntity->teleport($this->getPosition());
				}
			}
			$this->kill();
			$hasUpdate = true;
		}

		$this->timings->stopTiming();

		return $hasUpdate;
	}
	
	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = ThrownEnderPearl::NETWORK_ID;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}
}