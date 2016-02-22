<?php

namespace pocketmine\entity;

use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\Compound;
use pocketmine\Player;

class Egg extends Projectile{
	const NETWORK_ID = 82;
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
			$this->kill();
			$hasUpdate = true;
			if(mt_rand(1, 8) === 1){
				$chicken = null;
				$chunk = $this->chunk;
				
				if(!($chunk instanceof FullChunk)){
					return false;
				}
				
				$nbt = new Compound("", ["Pos" => new Enum("Pos", [new Double("", $this->getX()),new Double("", $this->getY()),new Double("", $this->getZ())]),
						"Motion" => new Enum("Motion", [new Double("", 0),new Double("", 0),new Double("", 0)]),"Rotation" => new Enum("Rotation", [new Float("", mt_rand(0, 360)),new Float("", 0)])]);
				$nbt->Age = new String("Age", 0);
				$chicken = Entity::createEntity("Chicken", $chunk, $nbt);
				if($chicken instanceof Entity){
					$chicken->setDataProperty(14, self::DATA_TYPE_INT, 0);
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
