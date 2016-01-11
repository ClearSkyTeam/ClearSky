<?php
namespace pocketmine\metadata;

use pocketmine\plugin\Plugin;

interface Metadatable{

	/**
	 * Sets a metadata value in the implementing object's metadata store.
	 *
	 * @param string        $metadataKey
	 * @param MetadataValue $newMetadataValue
	 *
	 * @return void
	 */
	public function setMetadata($metadataKey, MetadataValue $newMetadataValue);

	/**
	 * Returns a list of previously set metadata values from the implementing
	 * object's metadata store.
	 *
	 * @param string $metadataKey
	 *
	 * @return MetadataValue[]
	 */
	public function getMetadata($metadataKey);

	/**
	 * Tests to see whether the implementing object contains the given
	 * metadata value in its metadata store.
	 *
	 * @param string $metadataKey
	 *
	 * @return boolean
	 */
	public function hasMetadata($metadataKey);

	/**
	 * Removes the given metadata value from the implementing object's
	 * metadata store.
	 *
	 * @param string $metadataKey
	 * @param Plugin $owningPlugin
	 *
	 * @return void
	 */
	public function removeMetadata($metadataKey, Plugin $owningPlugin);

}