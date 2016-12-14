<?php
namespace pocketmine\tile;

use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\FloatTag;

class Beacon extends Spawnable{

	public function __construct(FullChunk $chunk, CompoundTag $nbt){
		parent::__construct($chunk, $nbt);
	}

	public function saveNBT(){
		parent::saveNBT();
	}

	public function getName(){
		return "Beacon";
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
			new StringTag("id", Tile::BEACON),
			new IntTag("x", (int) $this->x),
			new IntTag("y", (int) $this->y),
			new IntTag("z", (int) $this->z)
		]);
	}
}