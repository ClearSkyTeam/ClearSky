<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class SetSpawnPositionPacket extends DataPacket{
	const NETWORK_ID = Info::SET_SPAWN_POSITION_PACKET;

	public $x;
	public $y;
	public $z;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putInt($this->x);
		$this->putInt($this->y);
		$this->putInt($this->z);
	}

}
