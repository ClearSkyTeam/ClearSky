<?php
namespace pocketmine\tile;

use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;

class Sign extends Spawnable{

	public function __construct(FullChunk $chunk, Compound $nbt){
		if(!isset($nbt->Text1)){
			$nbt->Text1 = new StringTag("Text1", "");
		}
		if(!isset($nbt->Text2)){
			$nbt->Text2 = new StringTag("Text2", "");
		}
		if(!isset($nbt->Text3)){
			$nbt->Text3 = new StringTag("Text3", "");
		}
		if(!isset($nbt->Text4)){
			$nbt->Text4 = new StringTag("Text4", "");
		}

		parent::__construct($chunk, $nbt);
	}

	public function saveNBT(){
		parent::saveNBT();
		unset($this->namedtag->Creator);
	}

	public function setText($line1 = "", $line2 = "", $line3 = "", $line4 = ""){
		$this->namedtag->Text1 = new StringTag("Text1", $line1);
		$this->namedtag->Text2 = new StringTag("Text2", $line2);
		$this->namedtag->Text3 = new StringTag("Text3", $line3);
		$this->namedtag->Text4 = new StringTag("Text4", $line4);
		$this->spawnToAll();

		return true;
	}

	public function getText(){
		return [
			$this->namedtag["Text1"],
			$this->namedtag["Text2"],
			$this->namedtag["Text3"],
			$this->namedtag["Text4"]
		];
	}

	public function getSpawnCompound(){
		return new CompoundTag("", [
			new StringTag("id", Tile::SIGN),
			$this->namedtag->Text1,
			$this->namedtag->Text2,
			$this->namedtag->Text3,
			$this->namedtag->Text4,
			new IntTag("x", (int) $this->x),
			new IntTag("y", (int) $this->y),
			new IntTag("z", (int) $this->z)
		]);
	}

}
