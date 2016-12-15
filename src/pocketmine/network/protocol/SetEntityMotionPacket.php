<?php

namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class SetEntityMotionPacket extends DataPacket{
	const NETWORK_ID = Info::SET_ENTITY_MOTION_PACKET;
	
	public $eid;
	public $motionX;
	public $motionY;
	public $motionZ;

	public function clean(){
		$this->entities = [];
		return parent::clean();
	}
	
	public function decode(){//Horses had this idea.. So client could 'hack' a horse in, sit on it and cheat speed/jump hack legally
		$this->eid = $this->getEntityId();
		$this->getVector3f($this->motionX, $this->motionY, $this->motionZ);
	}
	
	public function encode(){
		$this->reset();
		$this->putEntityId($this->eid);
		$this->putVector3f($this->motionX, $this->motionY, $this->motionZ);
	}
}
