<?php
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

#include <rules/NBT.h>

class Float extends NamedTag{

	public function getType(){
		return NBT::TAG_Float;
	}

	public function read(NBT $nbt){
		$this->value = $nbt->getFloat();
	}

	public function write(NBT $nbt){
		$nbt->putFloat($this->value);
	}
}