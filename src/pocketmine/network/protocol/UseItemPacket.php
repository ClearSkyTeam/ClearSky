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
        public $unknown;

	public function decode(){
		$this->x = $this->getInt();
		$this->y = $this->getInt();
		$this->z = $this->getInt();
		$this->face = $this->getByte();
		$this->fx = $this->getFloat();
		$this->fy = $this->getFloat();
		$this->fz = $this->getFloat();
		$this->posX = $this->getFloat();
		$this->posY = $this->getFloat();
		$this->posZ = $this->getFloat();
		
		$this->unknown = $this->getSignedShort();
		$this->slot = $this->getSignedShort();
		$this->item = $this->getSlot();
	}

	public function encode(){

	}

}
