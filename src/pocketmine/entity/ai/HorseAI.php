<?php

namespace pocketmine\entity\ai;

use pocketmine\entity\Human;
use pocketmine\entity\Wolf;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;

class HorseAI extends BaseAI{
	public static $speed = 0.2;
	public static $jump = 4;
	public static $dist = 4;
	public $width = 0.625;
	public $length = 1.4375;
	public $height = 1.25;

	public function calculateMovement($entitytype, $json){
		$jsondecode = json_decode($json, true);
		return json_encode($jsondecode);
	}
}