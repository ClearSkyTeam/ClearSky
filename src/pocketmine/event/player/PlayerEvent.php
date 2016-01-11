<?php
/**
 * Player-only related events
 */
namespace pocketmine\event\player;

use pocketmine\event\Event;

abstract class PlayerEvent extends Event{
	/** @var \pocketmine\Player */
	protected $player;

	public function getPlayer(){
		return $this->player;
	}
}