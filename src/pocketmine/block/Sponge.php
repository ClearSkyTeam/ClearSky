<?php
namespace pocketmine\block;


class Sponge extends Solid{

	protected $id = self::SPONGE;

	public function __construct(){

	}

	public function getHardness(){
		return 0.6;
	}

	public function getName(){
		return "Sponge";
	}

}