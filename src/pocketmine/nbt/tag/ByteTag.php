<?php
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

#include <rules/NBT.h>

class ByteTag extends NamedTag{

	public function getType(){
		return NBT::TAG_Byte;
	}

	public function read(NBT $nbt, bool $network = false){
		$this->value = $nbt->getByte();
	}

	public function write(NBT $nbt, bool $network = false){
		$nbt->putByte($this->value);
	}
}