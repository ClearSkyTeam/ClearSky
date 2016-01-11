<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class SetDifficultyPacket extends DataPacket{
	const NETWORK_ID = Info::SET_DIFFICULTY_PACKET;

	public $difficulty;

	public function decode(){
		$this->difficulty = $this->getInt();
	}

	public function encode(){
		$this->reset();
		$this->putInt($this->difficulty);
	}

}