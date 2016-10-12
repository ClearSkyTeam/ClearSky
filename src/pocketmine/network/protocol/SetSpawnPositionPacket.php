<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class SetSpawnPositionPacket extends DataPacket{
	const NETWORK_ID = Info::SET_SPAWN_POSITION_PACKET;

	public $unknown;
	public $x;
	public $y;
	public $z;
	public $unknownBool;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putVarInt($this->unknown);
		$this->putBlockCoords($this->x, $this->y, $this->z);
		$this->putBool($this->unknownBool);
	}

}
