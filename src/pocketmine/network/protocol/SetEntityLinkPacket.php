<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class SetEntityLinkPacket extends DataPacket{
	const NETWORK_ID = Info::SET_ENTITY_LINK_PACKET;
	const TYPE_REMOVE = 0;
	const TYPE_RIDE = 1;
	const TYPE_PASSENGER = 2;

	public $from;
	public $to;
	public $type;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putEntityId($this->from);
		$this->putEntityId($this->to);
		$this->putByte($this->type);
	}

}
