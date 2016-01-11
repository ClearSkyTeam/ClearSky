<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class ContainerSetDataPacket extends DataPacket{
	const NETWORK_ID = Info::CONTAINER_SET_DATA_PACKET;

	public $windowid;
	public $property;
	public $value;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putByte($this->windowid);
		$this->putShort($this->property);
		$this->putShort($this->value);
	}

}