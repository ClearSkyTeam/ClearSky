<?php
namespace pocketmine\level\particle;

use pocketmine\network\protocol\LevelEventPacket;
use pocketmine\block\Block;
use pocketmine\math\Vector3;

class DestroyBlockParticle extends Particle{
	
	protected $data;

	public function __construct(Vector3 $pos, Block $b){
		parent::__construct($pos->x, $pos->y, $pos->z);
		$this->data = $b->getId() + ($b->getDamage() << 12);
	}
	
	public function encode(){
		$pk = new LevelEventPacket;
		$pk->evid = LevelEventPacket::EVENT_PARTICLE_DESTROY;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->data = $this->data;
		
		return $pk;
	}
}
