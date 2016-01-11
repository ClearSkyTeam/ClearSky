<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class RemovePlayerPacket extends DataPacket{
	const NETWORK_ID = Info::REMOVE_PLAYER_PACKET;

	public $eid;
	public $clientId;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putLong($this->eid);
		$this->putUUID($this->clientId);
	}

}
