<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

#ifndef COMPILE
use pocketmine\utils\Binary;

#endif

class SetEntityDataPacket extends DataPacket{
	const NETWORK_ID = Info::SET_ENTITY_DATA_PACKET;

	public $eid;
	public $metadata;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putLong($this->eid);
		$meta = Binary::writeMetadata($this->metadata);
		$this->put($meta);
	}

}
