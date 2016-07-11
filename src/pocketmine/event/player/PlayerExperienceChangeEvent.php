<?php
namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerExperienceChangeEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;
	
	public $expTotal;
	public $expCurrent;
	public $expLevel;

	public function __construct(Player $player, $Total = 0, $Current = 0, $Level = 0){
		$this->expTotal = $Total;
		$this->expCurrent = $Current;
		$this->expLevel = $Level;
		$this->player = $player;
	}
	
	public function getExperience(){
		return $this->expTotal;
	}
	
	public function getCurrentExperience(){
		return $this->expCurrent;
	}
	
	public function getExperienceLevel(){
		return $this->expLevel;
	}
	
	public function setExperience($exp){
		$this->expCurrent = $exp;
	}
	
	public function setExperienceLevel($level){
		$this->expLevel = $level;
	}

}
