<?php
namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\Player;

/**
 * Called when a player leaves the server
 */
class PlayerKickEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var string */
	protected $quitMessage;

	/** @var string */
	protected $reason;

	public function __construct(Player $player, $reason, $quitMessage){
		$this->player = $player;
		$this->quitMessage = $quitMessage;
		$this->reason = $reason;
	}

	public function getReason(){
		return $this->reason;
	}

	public function setQuitMessage($quitMessage){
		$this->quitMessage = $quitMessage;
	}

	public function getQuitMessage(){
		return $this->quitMessage;
	}

}