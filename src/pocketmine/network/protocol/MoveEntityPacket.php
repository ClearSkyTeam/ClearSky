<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class MoveEntityPacket extends DataPacket{
	const NETWORK_ID = Info::MOVE_ENTITY_PACKET;


	// eid, x, y, z, yaw, pitch
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
		//$this->putInt(count($this->entities)); Seems like multipile Entity support has dropped TODO:CHECK_THIS
		foreach($this->entities as $d){
			$this->putLong($d[0]); //eid
			$this->putFloat($d[1]); //x
			$this->putFloat($d[2]); //y
			$this->putFloat($d[3]); //z
			$this->putFloat($d[6] * 0.71111); //pitch
			$this->putFloat($d[5] * 0.71111); //headYaw
			$this->putFloat($d[4] * 0.71111); //yaw
		}
	}

}
