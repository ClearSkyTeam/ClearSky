<?php
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

#include <rules/NBT.h>

class DoubleTag extends NamedTag{

	public function getType(){
		return NBT::TAG_Double;
	}

	public function read(NBT $nbt){
		$this->value = $nbt->getDouble();
	}

	public function write(NBT $nbt){
		$nbt->putDouble($this->value);
	}
}