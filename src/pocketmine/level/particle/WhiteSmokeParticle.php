<?php
namespace pocketmine\level\particle;

use pocketmine\math\Vector3;

class WhiteSmokeParticle extends GenericParticle{
	public function __construct(Vector3 $pos, $scale = 0){
		parent::__construct($pos, Particle::TYPE_WHITE_SMOKE, (int) $scale);
	}
}