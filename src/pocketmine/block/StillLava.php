<?php
namespace pocketmine\block;

class StillLava extends Lava{

	protected $id = self::STILL_LAVA;

	public function getName(){
		return "Still Lava";
	}

}