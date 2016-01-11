<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


use pocketmine\entity\Attribute;

class UpdateAttributePacket extends DataPacket{
	const NETWORK_ID = Info::UPDATE_ATTRIBUTES_PACKET;


	public $entityId;
	/** @var Attribute[] */
	public $entries;
	
	public $minValue;
	public $maxValue;
	public $name;
	public $value;

	public function decode(){

	}

	public function encode(){
		$this->reset();

		$this->putLong($this->entityId);

		$this->putShort(1);

		$this->putFloat($this->minValue);
		$this->putFloat($this->maxValue);
		$this->putFloat($this->value);
		$this->putString($this->name);
	}

}
