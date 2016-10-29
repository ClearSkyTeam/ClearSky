<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

#ifndef COMPILE
use pocketmine\utils\Binary;

#endif


class AddPlayerPacket extends DataPacket{
	const NETWORK_ID = Info::ADD_PLAYER_PACKET;

	public $uuid;
	public $username;
	public $eid;
	public $x;
	public $y;
	public $z;
	public $speedX;
	public $speedY;
	public $speedZ;
	public $pitch;
	public $headYaw;
	public $yaw;
	public $item;
	public $metadata = [];

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putUUID($this->uuid);
		$this->putString($this->username);
		$this->putEntityId($this->eid); //EntityUniqueID
		$this->putEntityId($this->eid); //EntityRuntimeID
		$this->putVector3f($this->x, $this->y, $this->z);
		$this->putVector3f($this->speedX, $this->speedY, $this->speedZ);
		$this->putLFloat($this->pitch);
		$this->putLFloat($this->headYaw ?? $this->yaw);
		$this->putLFloat($this->yaw);
		$this->putSlot($this->item);
		$meta = Binary::writeMetadata($this->metadata);
		$this->put($meta);
	}
}
