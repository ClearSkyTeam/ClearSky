<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class BossEventPacket extends DataPacket{
	const NETWORK_ID = Info::BOSS_EVENT_PACKET;

	public $eid;
	public $state;

	public function decode(){
		$this->eid = $this->getEntityId();
		$this->state = $this->getUnsignedVarInt();
	}

	public function encode(){
		$this->reset();
		$this->putEntityId($this->eid);
		$this->putUnsignedVarInt($this->state);
	}
}