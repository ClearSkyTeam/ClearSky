<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class RespawnPacket extends DataPacket{
	const NETWORK_ID = Info::RESPAWN_PACKET;

	public $x;
	public $y;
	public $z;

	public function decode(){
		$this->x = $this->getFloat();
		$this->y = $this->getFloat();
		$this->z = $this->getFloat();
	}

	public function encode(){
		$this->reset();
		$this->putFloat($this->x);
		$this->putFloat($this->y);
		$this->putFloat($this->z);
	}

}
