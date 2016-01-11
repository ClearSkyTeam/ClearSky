<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class EntityEventPacket extends DataPacket{
	const NETWORK_ID = Info::ENTITY_EVENT_PACKET;

	const HURT_ANIMATION = 2;
	const DEATH_ANIMATION = 3;

	const TAME_FAIL = 6;
	const TAME_SUCCESS = 7;
	const SHAKE_WET = 8;
	const USE_ITEM = 9;
	const EAT_GRASS_ANIMATION = 10;
	const FISH_HOOK_BUBBLE = 11;
	const FISH_HOOK_POSITION = 12;
	const FISH_HOOK_HOOK = 13;
	const FISH_HOOK_TEASE = 14;
	const SQUID_INK_CLOUD = 15;
	const AMBIENT_SOUND = 16;
	const RESPAWN = 17;

	//TODO add new events

	public $eid;
	public $event;

	public function decode(){
		$this->eid = $this->getLong();
		$this->event = $this->getByte();
	}

	public function encode(){
		$this->reset();
		$this->putLong($this->eid);
		$this->putByte($this->event);
	}

}
