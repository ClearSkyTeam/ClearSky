<?php
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

#include <rules/NBT.h>

class ShortTag extends NamedTag{

	public function getType(){
		return NBT::TAG_Short;
	}

	public function read(NBT $nbt, bool $network = false){
		$this->value = $nbt->getShort();
	}

	public function write(NBT $nbt, bool $network = false){
		$nbt->putShort($this->value);
	}
}