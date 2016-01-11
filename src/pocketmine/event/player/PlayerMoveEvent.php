<?php
namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\level\Location;
use pocketmine\Player;

class PlayerMoveEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;

	private $from;
	private $to;

	public function __construct(Player $player, Location $from, Location $to){
		$this->player = $player;
		$this->from = $from;
		$this->to = $to;
	}

	public function getFrom(){
		return $this->from;
	}

	public function setFrom(Location $from){
		$this->from = $from;
	}

	public function getTo(){
		return $this->to;
	}

	public function setTo(Location $to){
		$this->to = $to;
	}
}