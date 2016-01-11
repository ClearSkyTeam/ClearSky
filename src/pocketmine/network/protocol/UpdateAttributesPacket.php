<?php
namespace pocketmine\network\protocol;
#include <rules/DataPacket.h>
use pocketmine\entity\Attribute;
class UpdateAttributesPacket extends DataPacket{
	const NETWORK_ID = Info::UPDATE_ATTRIBUTES_PACKET;
	public $entityId;
	/** @var Attribute[] */
	public $entries = [];
	public function decode(){
	}
	public function encode(){
		$this->reset();
		$this->putLong($this->entityId);
		$this->putShort(count($this->entries));
		foreach($this->entries as $entry){
			$this->putFloat($entry->getMinValue());
			$this->putFloat($entry->getMaxValue());
			$this->putFloat($entry->getValue());
			$this->putString($entry->getName());
		}
	}
}