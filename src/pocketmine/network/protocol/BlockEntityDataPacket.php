<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class BlockEntityDataPacket extends DataPacket{
	const NETWORK_ID = Info::BLOCK_ENTITY_DATA_PACKET;

	public $x;
	public $y;
	public $z;
	public $namedtag;

	public function decode(){
		$this->x = $this->getInt();
		$this->y = $this->getInt();
		$this->z = $this->getInt();
		$this->namedtag = $this->get(true);
	}

	public function encode(){
		$this->reset();
		$this->putInt($this->x);
		$this->putInt($this->y);
		$this->putInt($this->z);
		$this->put($this->namedtag);
	}

}
