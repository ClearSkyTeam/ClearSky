<?php
namespace pocketmine\entity;

class Vehicle extends Entity implements Rideable{
	
	public function isVehicle(){
		return true;
	}
	
}