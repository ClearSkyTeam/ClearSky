<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\math\AxisAlignedBB;

class DaylightDetectorInverted extends Transparent implements Redstone, RedstoneSwitch{
	protected $id = self::DAYLIGHT_DETECTOR_INVERTED;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Inverted Daylight Detector";
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
		$this->id = self::DAYLIGHT_DETECTOR;
		$this->getLevel()->setBlock($this, $this, true);
		$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_NORMAL, $this->getPower());
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
		return 15 - $power;
	}

	protected function recalculateBoundingBox(){
		return new AxisAlignedBB(
			$this->x,
			$this->y,
			$this->z,
			$this->x + 1,
			$this->y + 0.375,
			$this->z + 1
		);
	}
}
