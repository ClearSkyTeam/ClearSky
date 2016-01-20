<?php
namespace pocketmine\entity;

class Vehicle extends Entity implements Rideable{
	
	public function isVehicle(){
		return true;
	}
	
	public function followEntity(Entity $entity){
		$this->setPosition($entity->temporalVector->setComponents($entity->x, $entity->y - 0.5, $entity->z));
	}
	
}