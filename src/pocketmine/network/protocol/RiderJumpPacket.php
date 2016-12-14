<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class RiderJumpPacket extends DataPacket{
	const NETWORK_ID = Info::RIDER_JUMP_PACKET;

	public $varint;

	public function decode(){
		$this->varint = $this->getVarInt();
	}

	public function encode(){
		$this->reset();
		$this->putVarInt($this->varint);
	}
}