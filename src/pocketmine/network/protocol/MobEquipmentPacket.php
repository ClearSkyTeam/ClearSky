<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class MobEquipmentPacket extends DataPacket{
	const NETWORK_ID = Info::MOB_EQUIPMENT_PACKET;

	public $eid;
	public $item;
	public $slot;
	public $selectedSlot;
	public $unknownByte;

	public function decode(){
		$this->eid = $this->getEntityId(); //EntityRuntimeID
		$this->item = $this->getSlot();
		$this->slot = $this->getByte();
		$this->selectedSlot = $this->getByte();
		$this->unknownByte = $this->getByte();
	}

	public function encode(){
		$this->reset();
		$this->putEntityId($this->eid); //EntityRuntimeID
		$this->putSlot($this->item);
		$this->putByte($this->slot);
		$this->putByte($this->selectedSlot);
		$this->putByte($this->unknownByte);
	}

}
