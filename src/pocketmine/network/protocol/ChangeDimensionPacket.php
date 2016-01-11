<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class ChangeDimensionPacket extends DataPacket{
	const NETWORK_ID = Info::CHANGE_DIMENSION_PACKET;

	const NORMAL = 0;
	const NETHER = 1;

	public $dimension;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putByte($this->dimension);
		$this->putByte(0);
	}

}