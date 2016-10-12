<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class SetPlayerGameTypePacket extends DataPacket{
	const NETWORK_ID = Info::SET_PLAYER_GAME_TYPE_PACKET;

	public $gamemode;

	public function decode(){
		$this->gamemode = $this->getVarInt();
	}

	public function encode(){
		$this->reset();
		$this->putVarInt($this->gamemode);
	}
}