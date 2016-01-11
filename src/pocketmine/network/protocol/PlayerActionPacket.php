<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class PlayerActionPacket extends DataPacket{
	const NETWORK_ID = Info::PLAYER_ACTION_PACKET;

	const ACTION_START_BREAK = 0;
	const ACTION_ABORT_BREAK = 1;
	const ACTION_STOP_BREAK = 2;


	const ACTION_RELEASE_ITEM = 5;
	const ACTION_STOP_SLEEPING = 6;
	const ACTION_RESPAWN = 7;
	const ACTION_JUMP = 8;
	const ACTION_START_SPRINT = 9;
	const ACTION_STOP_SPRINT = 10;
	const ACTION_START_SNEAK = 11;
	const ACTION_STOP_SNEAK = 12;
	const ACTION_DIMENSION_CHANGE = 13;

	public $eid;
	public $action;
	public $x;
	public $y;
	public $z;
	public $face;

	public function decode(){
		$this->eid = $this->getLong();
		$this->action = $this->getInt();
		$this->x = $this->getInt();
		$this->y = $this->getInt();
		$this->z = $this->getInt();
		$this->face = $this->getInt();
	}

	public function encode(){
		$this->reset();
		$this->putLong($this->eid);
		$this->putInt($this->action);
		$this->putInt($this->x);
		$this->putInt($this->y);
		$this->putInt($this->z);
		$this->putInt($this->face);
	}

}
