<?php
namespace pocketmine\level\particle;

use pocketmine\math\Vector3;

class DustParticle extends GenericParticle{
	public function __construct(Vector3 $pos, $r, $g, $b, $a = 255){
		parent::__construct($pos, Particle::TYPE_DUST, (($a & 0xff) << 24) | (($r & 0xff) << 16) | (($g & 0xff) << 8) | ($b & 0xff));
	}
}
