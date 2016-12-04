<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class EventPacket extends DataPacket{ // Related to BossEventPacket
	const NETWORK_ID = Info::EVENT_PACKET;

	public $eid1;
	public $varint1;
	public $byte1;

	public function decode(){
		$this->eid1 = $this->getEntityId();
		$this->varint1 = $this->getVarInt();
		$this->byte1 = $this->getByte();
		// 8 cases. 0,2 ->putVarInt. 3,6 -> putVarInt putVarInt. 1 -> putVarInt getVarInt64(void). 4 -> ReadOnlyBinaryStream::getVarInt64(void) ReadOnlyBinaryStream::getVarInt64(void). 5 -> getUnsignedVarInt(void) getVarInt(void) getVarInt(void). 7 -> getVarInt64(void) getVarInt(void) getVarInt(void)
	}

	public function encode(){
		$this->putEntityId($this->eid1);
		$this->putVarInt($this->varint1);
		$this->putByte($this->byte1);
		// 8 cases. 0,2 nothing. 3,6 -> putVarInt. 1 -> putVarInt. 4 -> writeVarInt64(long long) writeVarInt64(long long). 5 -> writeUnsignedVarInt(uint) writeVarInt(int). 7 -> writeVarInt64(long long) writeVarInt(int).
	}
}