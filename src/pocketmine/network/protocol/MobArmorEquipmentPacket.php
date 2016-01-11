<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class MobArmorEquipmentPacket extends DataPacket{
	const NETWORK_ID = Info::MOB_ARMOR_EQUIPMENT_PACKET;

	public $eid;
	public $slots = [];

	public function decode(){
		$this->eid = $this->getLong();
		$this->slots[0] = $this->getSlot();
		$this->slots[1] = $this->getSlot();
		$this->slots[2] = $this->getSlot();
		$this->slots[3] = $this->getSlot();
	}

	public function encode(){
		$this->reset();
		$this->putLong($this->eid);
		$this->putSlot($this->slots[0]);
		$this->putSlot($this->slots[1]);
		$this->putSlot($this->slots[2]);
		$this->putSlot($this->slots[3]);
	}

}
