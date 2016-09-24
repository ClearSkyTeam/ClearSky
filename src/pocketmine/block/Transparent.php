<?php
namespace pocketmine\block;


abstract class Transparent extends Block{

	public function isTransparent(){
		return true;
	}

	public function canPassThrough(){
		return true;
	}
}