<?php
namespace pocketmine\network\protocol;

use pocketmine\Server;

#include <rules/DataPacket.h>


class UpdateBlockPacket extends DataPacket{
	const NETWORK_ID = Info::UPDATE_BLOCK_PACKET;

	const FLAG_NONE      = 0b0000;
	const FLAG_NEIGHBORS = 0b0001;
    const FLAG_NETWORK   = 0b0010;
	const FLAG_NOGRAPHIC = 0b0100;
	const FLAG_PRIORITY  = 0b1000;

	const FLAG_ALL = (self::FLAG_NEIGHBORS | self::FLAG_NETWORK);
	const FLAG_ALL_PRIORITY = (self::FLAG_ALL | self::FLAG_PRIORITY);

	public $records = []; //x, z, y, blockId, blockData, flags

	public function decode(){

	}

	public function encode(){
		$this->reset();
		//$this->putInt(count($this->records));
		foreach($this->records as $r){
			$this->putInt($r[0]);
			$this->putInt($r[1]);
			$this->putByte($r[2]);
			if(Server::checkIfKnownBlock($r[3])){
				$blockId = $r[3];
			}else{
				$blockId = 0;
			}
			$this->putByte($blockId);
			$this->putByte(($r[5] << 4) | $r[4]);
		}
	}

}
