<?php
namespace pocketmine\level\format\anvil;

use pocketmine\level\format\LevelProvider;


class RegionLoader extends \pocketmine\level\format\mcregion\RegionLoader{

	public function __construct(LevelProvider $level, $regionX, $regionZ){
		$this->x = $regionX;
		$this->z = $regionZ;
		$this->levelProvider = $level;
		$this->filePath = $this->levelProvider->getPath() . "region/r.$regionX.$regionZ.mca";
		$exists = file_exists($this->filePath);
		touch($this->filePath);
		$this->filePointer = fopen($this->filePath, "r+b");
		stream_set_read_buffer($this->filePointer, 1024 * 16); //16KB
		stream_set_write_buffer($this->filePointer, 1024 * 16); //16KB
		if(!$exists){
			$this->createBlank();
		}else{
			$this->loadLocationTable();
		}

		$this->lastUsed = time();
	}

	protected function unserializeChunk($data){
		return Chunk::fromBinary($data, $this->levelProvider);
	}
}