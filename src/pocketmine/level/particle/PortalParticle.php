<?php
namespace pocketmine\level\particle;

use pocketmine\math\Vector3;

class PortalParticle extends GenericParticle{
	public function __construct(Vector3 $pos){
		parent::__construct($pos, Particle::TYPE_PORTAL);
	}
}
