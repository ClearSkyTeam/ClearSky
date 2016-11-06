<?php
namespace pocketmine\level\sound;

use pocketmine\math\Vector3;
use pocketmine\network\protocol\LevelEventPacket;

class EndermanTeleportSound extends GenericSound{
	public function __construct(Vector3 $pos){
		parent::__construct($pos, 'mob.endermen.portal');
	}
}
