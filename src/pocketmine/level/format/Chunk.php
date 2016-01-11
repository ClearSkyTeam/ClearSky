<?php
namespace pocketmine\level\format;

interface Chunk extends FullChunk{
	const SECTION_COUNT = 8;

	/**
	 * Tests whether a section (mini-chunk) is empty
	 *
	 * @param $fY 0-7, (Y / 16)
	 *
	 * @return bool
	 */
	public function isSectionEmpty($fY);

	/**
	 * @param int $fY 0-7
	 *
	 * @return ChunkSection
	 */
	public function getSection($fY);

	/**
	 * @param int          $fY 0-7
	 * @param ChunkSection $section
	 *
	 * @return boolean
	 */
	public function setSection($fY, ChunkSection $section);

	/**
	 * @return ChunkSection[]
	 */
	public function getSections();

}