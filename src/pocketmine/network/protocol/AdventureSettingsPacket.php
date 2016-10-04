<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class AdventureSettingsPacket extends DataPacket{
	const NETWORK_ID = Info::ADVENTURE_SETTINGS_PACKET;

	public $flags;
        public $userPermission;
        public $globalPermission;

	public function decode(){
		$this->flags = $this->getUnsignedVarInt();
		$this->userPermission = $this->getUnsignedVarInt();
	}

	public function encode(){
		$this->reset();
		$this->putUnsignedVarInt($this->flags);
		$this->putUnsignedVarInt($this->userPermission); //TODO: verify this
		//$this->putInt($this->globalPermission);
	}

}