<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class InteractPacket extends DataPacket{
	const NETWORK_ID = Info::INTERACT_PACKET;
	
	const ACTION_RIGHT_CLICK = 1;
	const ACTION_LEFT_CLICK = 2;
	const ACTION_LEAVE_VEHICLE = 3;
	const ACTION_MOUSEOVER = 4;

	public $action;
	public $target;

	public function decode(){
		$this->action = $this->getByte();
		$this->target = $this->getEntityId();
	}

	public function encode(){
		$this->reset();
		$this->putByte($this->action);
		$this->putEntityId($this->target);
	}

}
