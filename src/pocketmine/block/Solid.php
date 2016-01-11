<?php
namespace pocketmine\block;

abstract class Solid extends Block{

	public function isSolid(){
		return true;
	}
}