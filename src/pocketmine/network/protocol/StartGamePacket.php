<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class StartGamePacket extends DataPacket{
	const NETWORK_ID = Info::START_GAME_PACKET;

	public $seed;
	public $dimension;
	public $generator;
	public $gamemode;
	public $eid;
	public $spawnX;
	public $spawnY;
	public $spawnZ;
	public $x;
	public $y;
	public $z;
	public $unknown;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putInt($this->seed);
		$this->putByte($this->dimension);
		$this->putInt($this->generator);
		$this->putInt($this->gamemode);
		$this->putLong($this->eid);
		$this->putInt($this->spawnX);
		$this->putInt($this->spawnY);
		$this->putInt($this->spawnZ);
		$this->putFloat($this->x);
		$this->putFloat($this->y);
		$this->putFloat($this->z);
                $this->putByte(1);
                $this->putByte(1);
                $this->putByte(0);
                $this->putString($this->unknown);
	}

}
