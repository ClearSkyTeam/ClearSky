<?php
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

#include <rules/NBT.h>

class ByteArray extends NamedTag{

	public function getType(){
		return NBT::TAG_ByteArray;
	}

	public function read(NBT $nbt){
		$this->value = $nbt->get($nbt->getInt());
	}

	public function write(NBT $nbt){
		$nbt->putInt(strlen($this->value));
		$nbt->put($this->value);
	}
}