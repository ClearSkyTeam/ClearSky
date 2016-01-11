<?php
namespace pocketmine\level\format\generic;

use pocketmine\level\format\ChunkSection;
use pocketmine\utils\ChunkException;

/**
 * Stub used to detect empty chunks
 */
class EmptyChunkSection implements ChunkSection{

	private $y;

	public function __construct($y){
		$this->y = $y;
	}

	final public function getY(){
		return $this->y;
	}

	final public function getBlockId($x, $y, $z){
		return 0;
	}

	final public function getBlockIdColumn($x, $z){
		return "\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00";
	}

	final public function getBlockDataColumn($x, $z){
		return "\x00\x00\x00\x00\x00\x00\x00\x00";
	}

	final public function getBlockSkyLightColumn($x, $z){
		return "\xff\xff\xff\xff\xff\xff\xff\xff";
	}

	final public function getBlockLightColumn($x, $z){
		return "\x00\x00\x00\x00\x00\x00\x00\x00";
	}

	final public function getFullBlock($x, $y, $z){
		return 0;
	}

	final public function getBlock($x, $y, $z, &$id = null, &$meta = null){
		$id = 0;
		$meta = 0;
	}

	final public function setBlock($x, $y, $z, $id = null, $meta = null){
		throw new ChunkException("Tried to modify an empty Chunk");
	}

	public function getIdArray(){
		return str_repeat("\x00", 4096);
	}

	public function getDataArray(){
		return str_repeat("\x00", 2048);
	}

	public function getSkyLightArray(){
		return str_repeat("\xff", 2048);
	}

	public function getLightArray(){
		return str_repeat("\x00", 2048);
	}

	final public function setBlockId($x, $y, $z, $id){
		throw new ChunkException("Tried to modify an empty Chunk");
	}

	final public function getBlockData($x, $y, $z){
		return 0;
	}

	final public function setBlockData($x, $y, $z, $data){
		throw new ChunkException("Tried to modify an empty Chunk");
	}

	final public function getBlockLight($x, $y, $z){
		return 0;
	}

	final public function setBlockLight($x, $y, $z, $level){
		throw new ChunkException("Tried to modify an empty Chunk");
	}

	final public function getBlockSkyLight($x, $y, $z){
		return 15;
	}

	final public function setBlockSkyLight($x, $y, $z, $level){
		throw new ChunkException("Tried to modify an empty Chunk");
	}
}