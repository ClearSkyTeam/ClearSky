<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class BatchPacket extends DataPacket{
	const NETWORK_ID = Info::BATCH_PACKET;

	public $payload;

	public function decode(){
		$this->payload = $this->getString();
	}

	public function encode(){
		$this->reset();
		$this->putString($this->payload);
	}

}