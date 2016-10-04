<?php
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

#include <rules/NBT.h>

class DoubleTag extends NamedTag{

	public function getType(){
		return NBT::TAG_Double;
	}

	public function read(NBT $nbt, bool $network = false){
		$this->value = $nbt->getDouble();
	}

	public function write(NBT $nbt, bool $network = false){
		$nbt->putDouble($this->value);
	}
}