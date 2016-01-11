<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class AnimatePacket extends DataPacket{
	const NETWORK_ID = Info::ANIMATE_PACKET;

	public $action;
	public $eid;

	public function decode(){
		$this->action = $this->getByte();
		$this->eid = $this->getLong();
	}

	public function encode(){
		$this->reset();
		$this->putByte($this->action);
		$this->putLong($this->eid);
	}

}
