<?php
namespace pocketmine\tile;

use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\tile\Spawnable;

class Music extends Spawnable{

	public function __construct(FullChunk $chunk, CompoundTag $nbt){
		if(!isset($nbt->note)){
			$nbt->note = new ByteTag("note", 0);
		}
		parent::__construct($chunk, $nbt);
	}

	public function getNote(){
		return $this->namedtag["note"];
	}

	public function setNote($note){
		$this->namedtag->note = new ByteTag("note", $note);
	}

	public function getSpawnCompound(){
		return new CompoundTag("", [
			new StringTag("id", Tile::NOTEBLOCK),
			new IntTag("x", (int) $this->x),
			new IntTag("y", (int) $this->y),
			new IntTag("z", (int) $this->z),
			new ByteTag("note", $this->namedtag["note"])
		]);	
	}
}