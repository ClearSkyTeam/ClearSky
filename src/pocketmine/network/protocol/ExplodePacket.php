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
		$this->putFloat($this->x);
		$this->putFloat($this->y);
		$this->putFloat($this->z);
		$this->putFloat($this->radius);
		$this->putInt(count($this->records));
		if(count($this->records) > 0){
			foreach($this->records as $record){
				$this->putByte($record->x);
				$this->putByte($record->y);
				$this->putByte($record->z);
			}
		}
	}

}