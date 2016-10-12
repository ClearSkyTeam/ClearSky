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
		$this->putEntityId($this->eid);
		$this->putByte($this->eventId);
		$this->putVarInt($this->effectId);
		$this->putVarInt($this->amplifier);
		$this->putBool($this->particles);
		$this->putVarInt($this->duration);
	}

}
