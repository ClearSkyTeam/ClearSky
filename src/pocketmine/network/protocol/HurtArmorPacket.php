<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class HurtArmorPacket extends DataPacket{
	const NETWORK_ID = Info::HURT_ARMOR_PACKET;

	public $health;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putByte($this->health);
	}

}