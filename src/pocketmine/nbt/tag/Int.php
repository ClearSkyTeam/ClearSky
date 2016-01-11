<?php
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

#include <rules/NBT.h>

class Int extends NamedTag{

	public function getType(){
		return NBT::TAG_Int;
	}

	public function read(NBT $nbt){
		$this->value = $nbt->getInt();
	}

	public function write(NBT $nbt){
		$nbt->putInt($this->value);
	}
}