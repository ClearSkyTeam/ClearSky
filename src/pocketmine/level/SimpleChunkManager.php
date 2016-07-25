<?php
declare(strict_types=1);
namespace pocketmine\level;

use pocketmine\level\format\FullChunk;

class SimpleChunkManager implements ChunkManager{

	/** @var FullChunk[] */
	protected $chunks = [];

	protected $seed;

	public function __construct($seed){
		$this->seed = $seed;
	}

	/**
	 * Gets the raw block id.
	 *
	 * @param int $x
	 * @param int $y
	 * @param int $z
	 *
	 * @return int 0-255
	 */
	public function getBlockIdAt($x, $y, $z){
		if($chunk = $this->getChunk($x >> 4, $z >> 4)){
			return $chunk->getBlockId($x & 0xf, $y & 0x7f, $z & 0xf);
		}
		return 0;
	}

	/**
	 * Sets the raw block id.
	 *
	 * @param int $x
	 * @param int $y
	 * @param int $z
	 * @param int $id 0-255
	 */
	public function setBlockIdAt($x, $y, $z, $id){
		if($chunk = $this->getChunk($x >> 4, $z >> 4)){
			$chunk->setBlockId($x & 0xf, $y & 0x7f, $z & 0xf, $id);
		}
	}

	/**
	 * Gets the raw block metadata
	 *
	 * @param int $x
	 * @param int $y
	 * @param int $z
	 *
	 * @return int 0-15
	 */
	public function getBlockDataAt($x, $y, $z){
		if($chunk = $this->getChunk($x >> 4, $z >> 4)){
			return $chunk->getBlockData($x & 0xf, $y & 0x7f, $z & 0xf);
		}
		return 0;
	}

	/**
	 * Sets the raw block metadata.
	 *
	 * @param int $x
	 * @param int $y
	 * @param int $z
	 * @param int $data 0-15
	 */
	public function setBlockDataAt($x, $y, $z, $data){
		if($chunk = $this->getChunk($x >> 4, $z >> 4)){
			$chunk->setBlockData($x & 0xf, $y & 0x7f, $z & 0xf, $data);
		}
	}

	/**
	 * @param int $chunkX
	 * @param int $chunkZ
	 *
	 * @return FullChunk|null
	 */
	public function getChunk($chunkX, $chunkZ){
		return isset($this->chunks[$index = Level::chunkHash($chunkX, $chunkZ)]) ? $this->chunks[$index] : null;
	}

	/**
	 * @param int $chunkX
	 * @param int $chunkZ
	 * @param FullChunk $chunk
	 */
	public function setChunk($chunkX, $chunkZ, FullChunk $chunk = null){
		if($chunk === null){
			unset($this->chunks[Level::chunkHash($chunkX, $chunkZ)]);
			return;
		}
		$this->chunks[Level::chunkHash($chunkX, $chunkZ)] = $chunk;
	}

	public function cleanChunks(){
		$this->chunks = [];
	}

	/**
	 * Gets the level seed
	 *
	 * @return int
	 */
	public function getSeed(){
		return $this->seed;
	}
	
	/** needs to be enhanced */
	public function getWaterHeight(){
		return 64;
	}
}