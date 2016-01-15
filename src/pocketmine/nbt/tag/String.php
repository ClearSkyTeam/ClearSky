<?php
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

#include <rules/NBT.h>

class String extends NamedTag{
	
	public function getType(){
		return NBT::TAG_String;
	}

	public function read(NBT $nbt){
		$this->value = $nbt->get($nbt->getShort());
	}

	public function write(NBT $nbt){
		$nbt->putShort(strlen($this->value));
		$nbt->put($this->value);
	}
}