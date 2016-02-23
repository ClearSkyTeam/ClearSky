<?php

namespace pocketmine\entity;

class Snake extends Entity{
	// Have fun guessing why
	public function kill(){
		parent::kill();
		foreach($this->getDrops() as $item){
			$this->getLevel()->dropItem($this, $item);
		}
		$this->close();
	}

	public function getDrops(){
		return [];
	}
}