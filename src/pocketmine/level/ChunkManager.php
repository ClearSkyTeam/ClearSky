<?php
namespace pocketmine\level;

use pocketmine\level\format\FullChunk;

interface ChunkManager{
	/**
	 * Gets the raw block id.
	 *
	 * @param int $x
	 * @param int $y
	 * @param int $z
	 *
	 * @return int 0-255
	 */
	public function getBlockIdAt($x, $y, $z);

	/**
	 * Sets the raw block id.
	 *
	 * @param int $x
	 * @param int $y
	 * @param int $z
	 * @param int $id 0-255
	 */
	public function setBlockIdAt($x, $y, $z, $id);

	/**
	 * Gets the raw block metadata
	 *
	 * @param int $x
	 * @param int $y
	 * @param int $z
	 *
	 * @return int 0-15
	 */
	public function getBlockDataAt($x, $y, $z);

	/**
	 * Sets the raw block metadata.
	 *
	 * @param int $x
	 * @param int $y
	 * @param int $z
	 * @param int $data 0-15
	 */
	public function setBlockDataAt($x, $y, $z, $data);

	/**
	 * @param int $chunkX
	 * @param int $chunkZ
	 *
	 * @return FullChunk
	 */
	public function getChunk($chunkX, $chunkZ);

	/**
	 * @param int $chunkX
	 * @param int $chunkZ
	 * @param FullChunk $chunk
	 */
	public function setChunk($chunkX, $chunkZ, FullChunk $chunk = null);

	/**
	 * Gets the level seed
	 *
	 * @return int
	 */
	public function getSeed();
}