<?php

namespace pocketmine\network\protocol;

class ChunkRadiusUpdatedPacket extends DataPacket{
	const NETWORK_ID = Info::CHUNK_RADIUS_UPDATED_PACKET;
	public $radius;

	public function decode(){}

	public function encode(){
		$this->reset();
		$this->putInt($this->radius);
	}
}