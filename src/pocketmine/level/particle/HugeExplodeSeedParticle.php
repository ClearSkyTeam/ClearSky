<?php
namespace pocketmine\level\particle;

use pocketmine\math\Vector3;

class HugeExplodeSeedParticle extends GenericParticle{
	public function __construct(Vector3 $pos){
		parent::__construct($pos, Particle::TYPE_HUGE_EXPLODE_SEED);
	}
}