<?php
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

#include <rules/NBT.h>

class ByteArrayTag extends NamedTag{

	public function getType(){
		return NBT::TAG_ByteArray;
	}

	public function read(NBT $nbt, bool $network = false){
		$this->value = $nbt->get($nbt->getInt($network));
	}

	public function write(NBT $nbt, bool $network = false){
		$nbt->putInt(strlen($this->value), $network);
		$nbt->put($this->value);
	}
}