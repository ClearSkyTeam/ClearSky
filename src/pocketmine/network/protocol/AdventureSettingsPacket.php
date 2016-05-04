<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class AdventureSettingsPacket extends DataPacket{
	const NETWORK_ID = Info::ADVENTURE_SETTINGS_PACKET;

	public $flags;
        public $userPermission;
        public $globalPermission;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putInt($this->flags);
                $this->putInt($this->userPermission);
                $this->putInt($this->globalPermission);
	}

}