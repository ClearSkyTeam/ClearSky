<?php

namespace pocketmine\block;
use pocketmine\entity\Entity;
class Slimeblock extends Transparent{
	protected $id = self::SLIMEBLOCK;

	public function __construct($meta = 15){
		$this->meta = $meta;
	}
	public function getName(){
		return "Slime Block";
	}

	public function getHardness(){
		return 0;
	}

	public function hasEntityCollision(){
		return true;
	}

	public function onEntityCollide(Entity $entity){
		if(abs($entity->motionY) < 0.1 && !$entity->isSneaking()){
			(double) $d0 = 0.4 + abs($entity->motionY) * 0.2;
			$entity->motionX *= $d0;
			$entity->motionZ *= $d0;
		}
	}
}
