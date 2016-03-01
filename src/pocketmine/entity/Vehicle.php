<?php

namespace pocketmine\entity;

class Vehicle extends Snake implements Rideable{

	public function isVehicle(){
		return true;
	}
}