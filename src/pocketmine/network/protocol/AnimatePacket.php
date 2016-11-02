<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class AnimatePacket extends DataPacket{
	const NETWORK_ID = Info::ANIMATE_PACKET;

	public $action;
	public $eid;

	public function decode(){
		$this->action = $this->getVarInt();
		$this->eid = $this->getEntityId();
	}

	public function encode(){
		$this->reset();
		$this->putVarInt($this->action);
		$this->putEntityId($this->eid);
	}

}
