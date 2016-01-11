<?php
namespace pocketmine\event;


/**
 * Events that can be cancelled must use the interface Cancellable
 */
interface Cancellable{
	public function isCancelled();

	public function setCancelled($value = true);
}
