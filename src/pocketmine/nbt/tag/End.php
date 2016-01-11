<?php
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

class End extends Tag{

	public function getType(){
		return NBT::TAG_End;
	}

	public function read(NBT $nbt){

	}

	public function write(NBT $nbt){

	}
}