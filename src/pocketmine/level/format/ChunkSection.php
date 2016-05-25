<?php
namespace pocketmine\level\format;

interface ChunkSection{

	/**
	 * @return int
	 */
	public function getY();

	/**
	 * @param int $x 0-15
	 * @param int $y 0-15
	 * @param int $z 0-15
	 *
	 * @return int 0-255
	 */
	public function getBlockId($x, $y, $z);

	/**
	 * @param int $x  0-15
	 * @param int $y  0-15
	 * @param int $z  0-15
	 * @param int $id 0-255
	 */
	public function setBlockId($x, $y, $z, $id);

	/**
	 * @param int $x 0-15
	 * @param int $y 0-15
	 * @param int $z 0-15
	 *
	 * @return int 0-15
	 */
	public function getBlockData($x, $y, $z);

	/**
	 * @param int $x    0-15
	 * @param int $y    0-15
	 * @param int $z    0-15
	 * @param int $data 0-15
	 */
	public function setBlockData($x, $y, $z, $data);

	/**
	 * Gets block and meta in one go
	 *
	 * @param int $x 0-15
	 * @param int $y 0-15
	 * @param int $z 0-15
	 *
	 * @return int bitmap, (id << 4) | data
	 */
	public function getFullBlock($x, $y, $z);

	/**
	 * @param int $x       0-15
	 * @param int $y       0-15
	 * @param int $z       0-15
	 * @param int $blockId , if null, do not change
	 * @param int $meta    0-15, if null, do not change
	 *
	 * @return bool
	 */
	public function setBlock($x, $y, $z, $blockId = null, $meta = null);

	/**
	 * @param int $x 0-15
	 * @param int $y 0-15
	 * @param int $z 0-15
	 *
	 * @return int 0-15
	 */
	public function getBlockSkyLight($x, $y, $z);

	/**
	 * @param int $x     0-15
	 * @param int $y     0-15
	 * @param int $z     0-15
	 * @param int $level 0-15
	 */
	public function setBlockSkyLight($x, $y, $z, $level);

	/**
	 * @param int $x 0-15
	 * @param int $y 0-15
	 * @param int $z 0-15
	 *
	 * @return int 0-15
	 */
	public function getBlockLight($x, $y, $z);

	/**
	 * @param int $x     0-15
	 * @param int $y     0-15
	 * @param int $z     0-15
	 * @param int $level 0-15
	 */
	public function setBlockLight($x, $y, $z, $level);

	/**
	 * Returns a id column from low y to high y
	 *
	 * @param int $x 0-15
	 * @param int $z 0-15
	 *
	 * @return string[16]
	 */
	public function getBlockIdColumn($x, $z);

	/**
	 * Returns a data column from low y to high y
	 *
	 * @param int $x 0-15
	 * @param int $z 0-15
	 *
	 * @return string[8]
	 */
	public function getBlockDataColumn($x, $z);

	/**
	 * Returns a skylight column from low y to high y
	 *
	 * @param int $x 0-15
	 * @param int $z 0-15
	 *
	 * @return string[8]
	 */
	public function getBlockSkyLightColumn($x, $z);

	/**
	 * Returns a data column from low y to high y
	 *
	 * @param int $x 0-15
	 * @param int $z 0-15
	 *
	 * @return string[8]
	 */
	public function getBlockLightColumn($x, $z);

	public function getIdArray();

	public function getDataArray();

	public function getSkyLightArray();

	public function getLightArray();

}