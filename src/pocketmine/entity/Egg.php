<?php

namespace pocketmine\entity;

use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\StringTag;

class Egg extends Projectile{
	const NETWORK_ID = 82;
	public $width = 0.25;
	public $length = 0.25;
	public $height = 0.25;
	protected $gravity = 0.03;
	protected $drag = 0.01;

	public function __construct(FullChunk $chunk, CompoundTag $nbt, Entity $shootingEntity = null){
		parent::__construct($chunk, $nbt, $shootingEntity);
	}

	public function onUpdate($currentTick){
		if($this->closed){
			return false;
		}
		
		$this->timings->startTiming();
		
		$hasUpdate = parent::onUpdate($currentTick);
		
		if($this->age > 1200 or $this->isCollided){
			$this->kill();
			$hasUpdate = true;
			if(mt_rand(1, 8) === 1){
				$chicken = null;
				$chunk = $this->chunk;
				
				if(!($chunk instanceof FullChunk)){
					return false;
				}
				
				$nbt = new CompoundTag("", ["Pos" => new ListTag("Pos", [new DoubleTag("", $this->getX()),new DoubleTag("", $this->getY()),new DoubleTag("", $this->getZ())]),
						"Motion" => new ListTag("Motion", [new DoubleTag("", 0),new DoubleTag("", 0),new DoubleTag("", 0)]),"Rotation" => new ListTag("Rotation", [new FloatTag("", mt_rand(0, 360)),new FloatTag("", 0)])]);
				$nbt->Age = new StringTag("Age", 0);
				$chicken = Entity::createEntity("Chicken", $chunk, $nbt);
				if($chicken instanceof Entity){
					$chicken->setDataProperty(14, self::DATA_TYPE_BYTE, 0);
					$chicken->spawnToAll();
				}
			}
		}
		
		$this->timings->stopTiming();
		
		return $hasUpdate;
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = Egg::NETWORK_ID;
		
		$player->dataPacket($pk);
		parent::spawnTo($player);
	}
}
