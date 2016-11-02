<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class ExplodePacket extends DataPacket{
	const NETWORK_ID = Info::EXPLODE_PACKET;

	public $x;
	public $y;
	public $z;
	public $radius;
	public $records = [];

	public function clean(){
		$this->records = [];
		return parent::clean();
	}

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putVector3f($this->x, $this->y, $this->z);
		$this->putLFloat($this->radius);
		$this->putUnsignedVarInt(count($this->records));
		if(count($this->records) > 0){
			foreach($this->records as $record){
				$this->putBlockCoords($record->x, $record->y, $record->z);
			}
		}
	}

}