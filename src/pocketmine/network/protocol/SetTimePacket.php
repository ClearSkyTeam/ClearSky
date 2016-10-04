<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class SetTimePacket extends DataPacket{
	const NETWORK_ID = Info::SET_TIME_PACKET;

	public $time;
	public $started = true;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putVarInt($this->time);
		$this->putByte((int) $this->started);
	}

}
