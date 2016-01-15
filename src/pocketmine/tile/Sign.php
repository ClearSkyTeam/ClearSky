<?php
namespace pocketmine\tile;

use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Int;
use pocketmine\nbt\tag\String;

class Sign extends Spawnable{

	public function __construct(FullChunk $chunk, Compound $nbt){
		if(!isset($nbt->Text1)){
			$nbt->Text1 = new String("Text1", "");
		}
		if(!isset($nbt->Text2)){
			$nbt->Text2 = new String("Text2", "");
		}
		if(!isset($nbt->Text3)){
			$nbt->Text3 = new String("Text3", "");
		}
		if(!isset($nbt->Text4)){
			$nbt->Text4 = new String("Text4", "");
		}

		parent::__construct($chunk, $nbt);
	}

	public function saveNBT(){
		parent::saveNBT();
		unset($this->namedtag->Creator);
	}

	public function setText($line1 = "", $line2 = "", $line3 = "", $line4 = ""){
		$this->namedtag->Text1 = new String("Text1", $line1);
		$this->namedtag->Text2 = new String("Text2", $line2);
		$this->namedtag->Text3 = new String("Text3", $line3);
		$this->namedtag->Text4 = new String("Text4", $line4);
		$this->spawnToAll();

		if($this->chunk){
			$this->chunk->setChanged();
			$this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
		}

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
		return new Compound("", [
			new String("id", Tile::SIGN),
			$this->namedtag->Text1,
			$this->namedtag->Text2,
			$this->namedtag->Text3,
			$this->namedtag->Text4,
			new Int("x", (int) $this->x),
			new Int("y", (int) $this->y),
			new Int("z", (int) $this->z)
		]);
	}

}
