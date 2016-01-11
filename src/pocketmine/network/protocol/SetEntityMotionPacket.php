<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class SetEntityMotionPacket extends DataPacket{
	const NETWORK_ID = Info::SET_ENTITY_MOTION_PACKET;


	// eid, motX, motY, motZ
	/** @var array[] */
	public $entities = [];

	public function clean(){
		$this->entities = [];
		return parent::clean();
	}

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putInt(count($this->entities));
		foreach($this->entities as $d){
			$this->putLong($d[0]); //eid
			$this->putFloat($d[1]); //motX
			$this->putFloat($d[2]); //motY
			$this->putFloat($d[3]); //motZ
		}
	}

}
