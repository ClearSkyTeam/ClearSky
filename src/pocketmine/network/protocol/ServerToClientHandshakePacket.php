<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class ServerToClientHandshakePacket extends DataPacket{
	const NETWORK_ID = Info::SERVER_TO_CLIENT_HANDSHAKE_PACKET;

	public $string1, $string2;

	public function decode(){
		$this->string1 = $this->getString();
		$this->string2 = $this->getString();
	}

	public function encode(){
		$this->reset();
		$this->putString("HEYTEST");//some weird xbox stuff here xbox::services::user_statistics::service_configuration_statistic::_Set_input_service_configuration_id(std::string)
		$this->putString("TESTZWEI");//TODO: test stuff with wireshark
	}
}