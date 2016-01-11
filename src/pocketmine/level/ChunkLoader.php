<?php
namespace pocketmine\level;

use pocketmine\block\Block;
use pocketmine\level\format\FullChunk;
use pocketmine\math\Vector3;

/**
 * If you want to keep chunks loaded and receive notifications on a specific area,
 * extend this class and register it into Level. This will also tick chunks.
 *
 * Register Level->registerChunkLoader($this, $chunkX, $chunkZ)
 * Unregister Level->unregisterChunkLoader($this, $chunkX, $chunkZ)
 *
 * WARNING: When moving this object around in the world or destroying it,
 * be sure to free the existing references from Level, otherwise you'll leak memory.
 */
interface ChunkLoader{

	/**
	 * Returns the ChunkLoader id.
	 * Call Level::generateChunkLoaderId($this) to generate and save it
	 *
	 * @return int
	 */
	public function getLoaderId();

	/**
	 * Returns if the chunk loader is currently active
	 *
	 * @return bool
	 */
	public function isLoaderActive();

	/**
	 * @return Position
	 */
	public function getPosition();

	/**
	 * @return float
	 */
	public function getX();

	/**
	 * @return float
	 */
	public function getZ();

	/**
	 * @return Level
	 */
	public function getLevel();

	/**
	 * This method will be called when a Chunk is replaced by a new one
	 *
	 * @param FullChunk $chunk
	 */
	public function onChunkChanged(FullChunk $chunk);

	/**
	 * This method will be called when a registered chunk is loaded
	 *
	 * @param FullChunk $chunk
	 */
	public function onChunkLoaded(FullChunk $chunk);


	/**
	 * This method will be called when a registered chunk is unloaded
	 *
	 * @param FullChunk $chunk
	 */
	public function onChunkUnloaded(FullChunk $chunk);

	/**
	 * This method will be called when a registered chunk is populated
	 * Usually it'll be sent with another call to onChunkChanged()
	 *
	 * @param FullChunk $chunk
	 */
	public function onChunkPopulated(FullChunk $chunk);

	/**
	 * This method will be called when a block changes in a registered chunk
	 *
	 * @param Block|Vector3 $block
	 */
	public function onBlockChanged(Vector3 $block);

}