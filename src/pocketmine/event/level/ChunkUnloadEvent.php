<?php
namespace pocketmine\event\level;

use pocketmine\event\Cancellable;

/**
 * Called when a Chunk is unloaded
 */
class ChunkUnloadEvent extends ChunkEvent implements Cancellable{
	public static $handlerList = null;
}