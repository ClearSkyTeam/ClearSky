<?php
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

#include <rules/NBT.h>

class Short extends NamedTag{

	public function getType(){
		return NBT::TAG_Short;
	}

	public function read(NBT $nbt){
		$this->value = $nbt->getShort();
	}

	public function write(NBT $nbt){
		$nbt->putShort($this->value);
	}
}