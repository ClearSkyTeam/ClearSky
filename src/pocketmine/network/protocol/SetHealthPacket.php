<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class SetHealthPacket extends DataPacket{
	const NETWORK_ID = Info::SET_HEALTH_PACKET;

	public $health;

	public function decode(){
		$this->health = $this->getInt();
	}

	public function encode(){
		$this->reset();
		$this->putInt($this->health);
	}

}