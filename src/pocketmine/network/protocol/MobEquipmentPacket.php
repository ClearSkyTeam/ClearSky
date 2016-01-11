<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class MobEquipmentPacket extends DataPacket{
	const NETWORK_ID = Info::MOB_EQUIPMENT_PACKET;

	public $eid;
	public $item;
	public $slot;
	public $selectedSlot;

	public function decode(){
		$this->eid = $this->getLong();
		$this->item = $this->getSlot();
		$this->slot = $this->getByte();
		$this->selectedSlot = $this->getByte();
	}

	public function encode(){
		$this->reset();
		$this->putLong($this->eid);
		$this->putSlot($this->item);
		$this->putByte($this->slot);
		$this->putByte($this->selectedSlot);
	}

}
