<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class ContainerSetContentPacket extends DataPacket{
	const NETWORK_ID = Info::CONTAINER_SET_CONTENT_PACKET;

	const SPECIAL_INVENTORY = 0;
	const SPECIAL_ARMOR = 0x78;
	const SPECIAL_CREATIVE = 0x79;

	public $windowid;
	public $slots = [];
	public $hotbar = [];

	public function clean(){
		$this->slots = [];
		$this->hotbar = [];
		return parent::clean();
	}

	public function decode(){
		$this->windowid = $this->getByte();
		$count = $this->getShort();
		for($s = 0; $s < $count and !$this->feof(); ++$s){
			$this->slots[$s] = $this->getSlot();
		}
		if($this->windowid === self::SPECIAL_INVENTORY){
			$count = $this->getShort();
			for($s = 0; $s < $count and !$this->feof(); ++$s){
				$this->hotbar[$s] = $this->getInt();
			}
		}
	}

	public function encode(){
		$this->reset();
		$this->putByte($this->windowid);
		$this->putShort(count($this->slots));
		foreach($this->slots as $slot){
			$this->putSlot($slot);
		}
		if($this->windowid === self::SPECIAL_INVENTORY and count($this->hotbar) > 0){
			$this->putShort(count($this->hotbar));
			foreach($this->hotbar as $slot){
				$this->putInt($slot);
			}
		}else{
			$this->putShort(0);
		}
	}

}