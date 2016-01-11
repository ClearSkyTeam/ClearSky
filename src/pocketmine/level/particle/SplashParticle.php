<?php
namespace pocketmine\level\particle;

use pocketmine\math\Vector3;

class SplashParticle extends GenericParticle{
	public function __construct(Vector3 $pos){
		parent::__construct($pos, Particle::TYPE_WATER_SPLASH);
	}
}
