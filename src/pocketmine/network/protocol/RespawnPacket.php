<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class RespawnPacket extends DataPacket{
	const NETWORK_ID = Info::RESPAWN_PACKET;

	public $x;
	public $y;
	public $z;

	public function decode(){
		$this->x = $this->getLFloat();
		$this->y = $this->getLFloat();
		$this->z = $this->getLFloat();
	}

	public function encode(){
		$this->reset();
		$this->putLFloat($this->x);
		$this->putLFloat($this->y);
		$this->putLFloat($this->z);
	}

}