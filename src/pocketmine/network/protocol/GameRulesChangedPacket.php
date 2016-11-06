<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class GameRulesChangedPacket extends DataPacket{// can be ignored for now
	const NETWORK_ID = Info::GAME_RULES_CHANGED_PACKET;

	public function decode(){}

	public function encode(){}
}