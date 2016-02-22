<?php

namespace pocketmine\entity;

use pocketmine\event\entity\EntityDeathEvent;

class Snake extends Entity{
	// Have fun guessing why
	public function kill(){
		parent::kill();
		$this->server->getPluginManager()->callEvent($ev = new EntityDeathEvent($this, $this->getDrops()));
		foreach($ev->getDrops() as $item){
			$this->getLevel()->dropItem($this, $item);
		}
	}

	public function getDrops(){
		return [];
	}
}