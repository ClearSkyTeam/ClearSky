<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class UseItemPacket extends DataPacket{
	const NETWORK_ID = Info::USE_ITEM_PACKET;

	public $x;
	public $y;
	public $z;
	public $face;
	public $item;
	public $fx;
	public $fy;
	public $fz;
	public $posX;
	public $posY;
	public $posZ;
	public $slot;

	public function decode(){
		$this->getBlockCoords($this->x, $this->y, $this->z);
		$this->face = $this->getVarInt();
		$this->getVector3f($this->fx, $this->fy, $this->fz);
		$this->getVector3f($this->posX, $this->posY, $this->posZ);
		$this->slot = $this->getVarInt();
		$this->item = $this->getSlot();
	}

	public function encode(){
		$this->reset();
		$this->putBlockCoords($this->x, $this->y, $this->z);
		$this->putVarInt($this->face);
		$this->putVector3f($this->fx, $this->fy, $this->fz);
		$this->putVector3f($this->posX, $this->posY, $this->posZ);
		$this->putVarInt($this->slot);
		$this->putSlot($this->item);
	}

}
