<?php
namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerToggleSneakEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var bool */
	protected $isSneaking;

	public function __construct(Player $player, $isSneaking){
		$this->player = $player;
		$this->isSneaking = (bool) $isSneaking;
	}

	public function isSneaking(){
		return $this->isSneaking;
	}

}