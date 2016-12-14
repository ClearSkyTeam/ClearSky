<?php
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

#include <rules/NBT.h>

class IntTag extends NamedTag{

	public function getType(){
		return NBT::TAG_Int;
	}

	public function read(NBT $nbt, bool $network = false){
		$this->value = $nbt->getInt($network);
	}

	public function write(NBT $nbt, bool $network = false){
		$nbt->putInt($this->value, $network);
	}
}