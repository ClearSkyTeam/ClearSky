<?php
namespace pocketmine\tile;

use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;

class Piston extends Spawnable{

	public function __construct(FullChunk $chunk, CompoundTag $nbt){
		parent::__construct($chunk, $nbt);
	}

	public function saveNBT(){
		parent::saveNBT();
	}

	public function getName(){
		return "Piston";
	}

	private function setChanged(){
		$this->spawnToAll();
		if($this->chunk instanceof FullChunk){
			$this->chunk->setChanged();
			$this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
		}
	}

	public function getSpawnCompound(){
		return new CompoundTag("", [
			new StringTag("id", Tile::PISTON),
			new IntTag("x", (int) $this->x),
			new IntTag("y", (int) $this->y),
			new IntTag("z", (int) $this->z),
			new IntTag("blockData", 0),
			new IntTag("blockId", 0),
			new ByteTag("extending", 0),
			new IntTag("facing", 0),
			new FloatTag("progress", 0.0),
		]);
	}
}