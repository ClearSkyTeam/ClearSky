<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class CraftingEventPacket extends DataPacket{
	const NETWORK_ID = Info::CRAFTING_EVENT_PACKET;

	public $windowId;
	public $type;
	public $id;
	public $input = [];
	public $output = [];

	public function clean(){
		$this->input = [];
		$this->output = [];
		return parent::clean();
	}

	public function decode(){
		$this->windowId = $this->getByte();
		$this->type = $this->getInt();
		$this->id = $this->getUUID();

		$size = $this->getInt();
		for($i = 0; $i < $size and $i < 128; ++$i){
			$this->input[] = $this->getSlot();
		}

		$size = $this->getInt();
		for($i = 0; $i < $size and $i < 128; ++$i){
			$this->output[] = $this->getSlot();
		}
	}

	public function encode(){

	}

}
