<?php
namespace pocketmine\block;

interface LightSource{
	public function getLightLevel(){
		return 15;
	}
	
	public function isLightSource(){
		return true;
	}
}