<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;

class DaylightDetector extends Transparent implements Redstone, RedstoneSwitch{
	protected $id = self::DAYLIGHT_DETECTOR;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Daylight Detector";
	}

	public function isRedstone(){
		return true;
	}

	public function canBeActivated(){
		return true;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_SCHEDULED || $type === Level::BLOCK_UPDATE_NORMAL){
			$this->getLevel()->scheduleUpdate($this, 50);
			$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_NORMAL, $this->getPower());
		}
		return false;
	}

	public function onActivate(Item $item, Player $player = null){
		$this->id = self::DAYLIGHT_DETECTOR_INVERTED;
		$this->getLevel()->setBlock($this, $this, true);
		$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_NORMAL, 16 - $this->getPower());
		return true;
	}

	public function getDrops(Item $item){
		return [[self::DAYLIGHT_DETECTOR,0,1]];
	}

	public function getPower(){
		$fulltime = Level::TIME_FULL;
		$time = ($fulltime + ((3000 - $this->getLevel()->getTime())) * 2);
		if($time < 0 || $time > $fulltime) $time *= -1;
		if($time < 0) $time += $fulltime * 2;
		$power = (floor($time / $fulltime * 15) + 1) - (15 - $this->getLightLevel());
		if($power < 0) $power = 0;
		return $power;
	}
}
