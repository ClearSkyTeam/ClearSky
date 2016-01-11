<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class MobEffectPacket extends DataPacket{
	const NETWORK_ID = Info::MOB_EFFECT_PACKET;

	const EVENT_ADD = 1;
	const EVENT_MODIFY = 2;
	const EVENT_REMOVE = 3;

	public $eid;
	public $eventId;
	public $effectId;
	public $amplifier;
	public $particles = true;
	public $duration;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putLong($this->eid);
		$this->putByte($this->eventId);
		$this->putByte($this->effectId);
		$this->putByte($this->amplifier);
		$this->putByte($this->particles ? 1 : 0);
		$this->putInt($this->duration);
	}

}
