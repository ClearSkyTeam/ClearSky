<?php

namespace pocketmine\entity\ai;

use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\block\Block;

class ZombieHorseAI extends HorseAI{
	public function calculateMovement($entitytype, $json){
		$this->x = $this->x - 0.5 + mt_rand(0,10)/10;
		$this->z = $this->z - 0.5 + mt_rand(0,10)/10;
		$this->x = $this->x - 0.5 + mt_rand(0,10)/10;
		$this->z = $this->z - 0.5 + mt_rand(0,10)/10;
		return $json;
	}
}