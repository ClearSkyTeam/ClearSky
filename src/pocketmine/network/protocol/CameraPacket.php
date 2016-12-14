<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class CameraPacket extends DataPacket{
	const NETWORK_ID = Info::CAMERA_PACKET;

	public $eid1; // Maybe playertarget
	public $eid2; // Maybe camera // I may confirm that. Write "only puts" eid1, and the camera should in theory know its own id.. except.. maybe it has schizophrenia

	public function decode(){
		$this->eid1 = $this->getEntityId();
		$this->eid2 = $this->getEntityId();
	}

	public function encode(){
		$this->reset();
		$this->putEntityId($this->eid1);
		$this->putEntityId($this->eid2);
	}
}