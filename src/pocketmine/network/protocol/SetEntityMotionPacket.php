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
	
	public function decode(){
	
	}
	
	public function encode(){
		$this->reset();
		$this->putEntityId($this->eid);
		$this->putVector3f($this->motionX, $this->motionY, $this->motionZ);
	}
}
