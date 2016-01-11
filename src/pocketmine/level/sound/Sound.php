<?php
namespace pocketmine\level\sound;

use pocketmine\math\Vector3;
use pocketmine\network\protocol\DataPacket;

abstract class Sound extends Vector3{
	
	/**
	 * @return DataPacket|DataPacket[]
	 */
	abstract public function encode();

}
