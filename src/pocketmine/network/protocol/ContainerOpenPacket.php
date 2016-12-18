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
	public $entityId = -1;

	public function decode(){
		$this->windowid = $this->getByte();
		$this->type = $this->getByte();
		$this->slots = $this->getVarInt();
		$this->getBlockCoords($this->x, $this->y, $this->z);
		$this->entityId = $this->getEntityId();
	}

	public function encode(){
		$this->reset();
		$this->putByte($this->windowid);
		$this->putByte($this->type);
		$this->putVarInt($this->slots);
		$this->putBlockCoords($this->x, $this->y, $this->z);
		$this->putEntityId($this->entityId);
	}

}
