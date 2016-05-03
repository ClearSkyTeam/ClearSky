<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class ContainerOpenPacket extends DataPacket{
	const NETWORK_ID = Info::CONTAINER_OPEN_PACKET;

	public $windowid;
	public $type;
	public $slots;
	public $x;
	public $y;
	public $z;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putByte($this->windowid);
		$this->putByte($this->type);
		$this->putShort($this->slots);
		$this->putInt($this->x);
		$this->putInt($this->y);
		$this->putInt($this->z);
	}

}