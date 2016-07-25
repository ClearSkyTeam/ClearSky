<?php
namespace pocketmine\event\player;

use pocketmine\Player;

/**
 * Called when a player leaves the server
 */
class PlayerQuitEvent extends PlayerEvent{
	public static $handlerList = null;

	/** @var string */
	protected $quitMessage;
	protected $autoSave = true;

	public function __construct(Player $player, $quitMessage, $autoSave = true){
		$this->player = $player;
		$this->quitMessage = $quitMessage;
		$this->autoSave = $autoSave;
	}

	public function setQuitMessage($quitMessage){
		$this->quitMessage = $quitMessage;
	}

	public function getQuitMessage(){
		return $this->quitMessage;
	}

	public function getAutoSave(){
		return $this->autoSave;
	}

	public function setAutoSave($value = true){
		$this->autoSave = (bool) $value;
	}

}