<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class BlockEventPacket extends DataPacket{
	const NETWORK_ID = Info::BLOCK_EVENT_PACKET;

	public $x;
	public $y;
	public $z;
	public $case1;
	public $case2;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putInt($this->x);
		$this->putInt($this->y);
		$this->putInt($this->z);
		$this->putInt($this->case1);
		$this->putInt($this->case2);
	}

}