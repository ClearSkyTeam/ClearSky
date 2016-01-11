<?php
namespace pocketmine\plugin;

use pocketmine\event\Event;
use pocketmine\event\Listener;

interface EventExecutor{

	/**
	 * @param Listener $listener
	 * @param Event    $event
	 *
	 * @return void
	 */
	public function execute(Listener $listener, Event $event);
}