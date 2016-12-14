<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class ClientToServerHandshakePacket extends DataPacket{ // An empty packet.. no en-/decryption
	const NETWORK_ID = Info::CLIENT_TO_SERVER_HANDSHAKE_PACKET;

	public function decode(){}

	public function encode(){}
}