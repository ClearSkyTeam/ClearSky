<?php

namespace pocketmine\entity;

use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\Compound;
use pocketmine\Player;
use pocketmine\item\Item as ItemItem;
use pocketmine\network\protocol\EntityEventPacket;
use pocketmine\Server;

class FishingHook extends Projectile{
	const NETWORK_ID = 77;
	public $width = 0.25;
	public $length = 0.25;
	public $height = 0.25;
	protected $gravity = 0.1;
	protected $drag = 0.05;
	public $data = 0;
	public $attractTimer = 100;
	public $coughtTimer = 0;
	public $damageRod = false;

	public function initEntity(){
		parent::initEntity();
		
		if(isset($this->namedtag->Data)){
			$this->data = $this->namedtag["Data"];
		}
		
		// $this->setDataProperty(FallingSand::DATA_BLOCK_INFO, self::DATA_TYPE_INT, $this->getData());
	}

	public function __construct(FullChunk $chunk, Compound $nbt, Entity $shootingEntity = null){
		parent::__construct($chunk, $nbt, $shootingEntity);
	}

	public function setData($id){
		$this->data = $id;
	}

	public function getData(){
		return $this->data;
	}

	public function kill(){
		parent::kill();
	}

	public function onUpdate($currentTick){
		if($this->closed){
			return false;
		}
		
		$this->timings->startTiming();
		
		$hasUpdate = parent::onUpdate($currentTick);
		
		if($this->isCollidedVertically && $this->isInsideOfWater()){
			$this->motionX = 0;
			$this->motionY += 0.01;
			$this->motionZ = 0;
			$this->motionChanged = true;
			$hasUpdate = true;
		}
		elseif($this->isCollided && $this->keepMovement === true){
			$this->motionX = 0;
			$this->motionY = 0;
			$this->motionZ = 0;
			$this->motionChanged = true;
			$this->keepMovement = false;
			$hasUpdate = true;
		}
		if($this->attractTimer === 0 && mt_rand(0, 100) <= 30){ // chance, that a fish bites
			$this->coughtTimer = mt_rand(5, 10) * 20; // random delay to catch fish
			$this->attractTimer = mt_rand(30, 100) * 20; // reset timer
			$this->attractFish();
			if($this->shootingEntity !== null)
				$this->shootingEntity->sendTip("A fish bites!");
		}
		elseif($this->attractTimer > 0){
			$this->attractTimer--;
		}
		if($this->coughtTimer > 0){
			$this->coughtTimer--;
			$this->fishBites();
		}
		
		$this->timings->stopTiming();
		
		return $hasUpdate;
	}

	public function fishBites(){
		if($this->shootingEntity instanceof Player){
			$pk = new EntityEventPacket();
			$pk->eid = $this->shootingEntity->getId();//$this or $this->shootingEntity
			$pk->event = EntityEventPacket::FISH_HOOK_HOOK;
			Server::broadcastPacket($this->shootingEntity->hasSpawned, $pk);
		}
	}

	public function attractFish(){
		if($this->shootingEntity instanceof Player){
			$pk = new EntityEventPacket();
			$pk->eid = $this->shootingEntity->getId();//$this or $this->shootingEntity
			$pk->event = EntityEventPacket::FISH_HOOK_BUBBLE;
			Server::broadcastPacket($this->shootingEntity->hasSpawned, $pk);
		}
	}

	public function reelLine(){
		$this->damageRod = false;
		if($this->shootingEntity !== null && $this->shootingEntity instanceof Player && $this->coughtTimer > 0){
			$fishs = array(ItemItem::RAW_FISH,ItemItem::RAW_SALMON,ItemItem::CLOWNFISH,ItemItem::PUFFERFISH);
			$fish = array_rand($fishs, 1);
			$fish = $fishs[$fish];
			$this->shootingEntity->getInventory()->addItem(ItemItem::get($fish));
			$this->shootingEntity->addExperience(mt_rand(1, 6));
			$this->damageRod = true;
		}
		if($this->shootingEntity !== null && $this->shootingEntity instanceof Player){
			$this->shootingEntity->unlinkHookFromPlayer($this->shootingEntity);
		}
		if(!$this->closed){
			$this->kill();
			$this->close();
		}
		return $this->damageRod;
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = FishingHook::NETWORK_ID;
		$pk->owner = $this->shootingEntity;
		
		$player->dataPacket($pk);
		parent::spawnTo($player);
	}
}
