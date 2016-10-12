<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class ChangeDimensionPacket extends DataPacket{
	const NETWORK_ID = Info::CHANGE_DIMENSION_PACKET;

	const NORMAL = 0;
	const NETHER = 1;

	public $dimension;
	public $x;
	public $y;
	public $z;
	public $unknown; //bool

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putVarInt($this->dimension);
		$this->putVector3f($this->x, $this->y, $this->z);
		$this->putBool($this->unknown);
	}

}