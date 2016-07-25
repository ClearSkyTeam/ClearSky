<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class MoveEntityPacket extends DataPacket{
	const NETWORK_ID = Info::MOVE_ENTITY_PACKET;

	public $eid;
	public $x;
	public $y;
	public $z;
	public $yaw;
	public $headYaw;
	public $pitch;

	public function decode(){
		$this->eid = $this->getLong();
		$this->x = $this->getFloat();
		$this->y = $this->getFloat();
		$this->z = $this->getFloat();
		$this->pitch = $this->getByte()*(360.0/256);
		$this->yaw = $this->getByte()*(360.0/256);
		$this->headYaw = $this->getByte()*(360.0/256);
	}

	public function encode(){
		$this->reset();
		$this->putLong($this->eid);
		$this->putFloat($this->x);
		$this->putFloat($this->y);
		$this->putFloat($this->z);
		$this->putByte($this->pitch/(360.0/256));
		$this->putByte($this->yaw/(360.0/256));
		$this->putByte($this->headYaw/(360.0/256));
	}
}
