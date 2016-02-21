<?php

namespace pocketmine\block;
class Slimeblock extends Transparent{
	protected $id = self::SLIMEBLOCK;

	public function __construct(){}

	public function getName(){
		return "Slime Block";
	}

	public function getHardness(){
		return 0;
	}

	public function hasEntityCollision(){
		return false;
	}
}