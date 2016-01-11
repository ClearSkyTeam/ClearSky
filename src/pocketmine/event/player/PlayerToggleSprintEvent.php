<?php
namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerToggleSprintEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var bool */
	protected $isSprinting;

	public function __construct(Player $player, $isSprinting){
		$this->player = $player;
		$this->isSprinting = (bool) $isSprinting;
	}

	public function isSprinting(){
		return $this->isSprinting;
	}

}