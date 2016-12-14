<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class ClientboundMapItemDataPacket extends DataPacket{ // An empty packet.. no en-/decryption
	const NETWORK_ID = Info::CLIENTBOUND_MAP_ITEM_DATA_PACKET;

	public function decode(){}

	public function encode(){}
}