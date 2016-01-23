<?php
namespace pocketmine\tile;

use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Int;
use pocketmine\nbt\tag\String;

class EnchantTable extends Spawnable implements Nameable{


	public function getName(){
		return isset($this->namedtag->CustomName) ? $this->namedtag->CustomName->getValue() : "Enchanting Table";
	}

	public function hasName(){
		return isset($this->namedtag->CustomName);
	}

	public function setName($str){
		if($str === ""){
			unset($this->namedtag->CustomName);
			return;
		}

		$this->namedtag->CustomName = new String("CustomName", $str);
	}

	public function getSpawnCompound(){
		$c = new Compound("", [
				new String("id", Tile::ENCHANT_TABLE),
				new Int("x", (int) $this->x),
				new Int("y", (int) $this->y),
				new Int("z", (int) $this->z)
		]);

		if($this->hasName()){
			$c->CustomName = $this->namedtag->CustomName;
		}

		return $c;
	}
}
