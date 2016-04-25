<?php

namespace pocketmine\block;

abstract class Flowable extends Transparent{

	public function canBeFlowedInto(){
		return true;
	}

	public function getHardness(){
		return 0;
	}

	public function getResistance(){
		return 0;
	}

	public function isSolid(){
		return false;
	}

	public function getBoundingBox(){
		return null;
	}
}