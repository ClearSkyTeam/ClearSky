<?php
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

#include <rules/NBT.h>

class FloatTag extends NamedTag{

	public function getType(){
		return NBT::TAG_Float;
	}

	public function read(NBT $nbt, bool $network = false){
		$this->value = $nbt->getFloat();
	}

	public function write(NBT $nbt, bool $network = false){
		$nbt->putFloat($this->value);
	}
}