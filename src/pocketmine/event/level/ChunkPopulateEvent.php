<?php
namespace pocketmine\event\level;

/**
 * Called when a Chunk is populated (after receiving it on the main thread)
 */
class ChunkPopulateEvent extends ChunkEvent{
	public static $handlerList = null;
}