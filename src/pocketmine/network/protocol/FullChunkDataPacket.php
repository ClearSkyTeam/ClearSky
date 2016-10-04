<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class FullChunkDataPacket extends DataPacket{
	const NETWORK_ID = Info::FULL_CHUNK_DATA_PACKET;
	
	const ORDER_COLUMNS = 0;
	const ORDER_LAYERED = 1;

	public $chunkX;
	public $chunkZ;
	public $order = self::ORDER_COLUMNS;
	public $data;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putVarInt($this->chunkX);
		$this->putVarInt($this->chunkZ);
		$this->putByte($this->order);
		$this->putString($this->data);
	}

}
