<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>



class PlayerListPacket extends DataPacket{
	const NETWORK_ID = Info::PLAYER_LIST_PACKET;

	const TYPE_ADD = 0;
	const TYPE_REMOVE = 1;

	//REMOVE: UUID; ADD: UUID, entity id, name, skinName, transparency, skin
	/** @var PlayerListEntry[] */
	public $entries = [];
	public $type;

	public function clean(){
		$this->entries = [];
		return parent::clean();
	}

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putByte($this->type);
		$this->putInt(count($this->entries));
		foreach($this->entries as $d){
			if($this->type === self::TYPE_ADD){
				$this->putUUID($d[0]);
				$this->putLong($d[1]);
				$this->putString($d[2]);
				$this->putString($d[3]);
//				$this->putByte($entry->transparency ? 1 : 0);
				$this->putString($d[4]);
			}else{
				$this->putUUID($d[0]);
			}
		}
	}

}
