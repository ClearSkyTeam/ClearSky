<?php
namespace pocketmine\level\particle;

use pocketmine\math\Vector3;

class SmokeParticle extends GenericParticle{
	public function __construct(Vector3 $pos, $scale = 0){
		parent::__construct($pos, Particle::TYPE_SMOKE, (int) $scale);
	}
}
