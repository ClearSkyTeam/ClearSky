<?php

namespace pocketmine\item;

abstract class Armor extends Item{

	public function getMaxStackSize(){
		return 1;
	}
}