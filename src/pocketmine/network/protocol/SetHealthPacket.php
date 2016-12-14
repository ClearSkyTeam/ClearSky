<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class SetHealthPacket extends DataPacket{
	const NETWORK_ID = Info::SET_HEALTH_PACKET;

	public $health;

	public function decode(){
		$this->health = $this->getVarInt();
	}

	public function encode(){
		$this->reset();
		$this->putVarInt($this->health);
	}

}