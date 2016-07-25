<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\level\Level;

class DaylightDetectorInverted extends DaylightDetector{
	protected $id = self::DAYLIGHT_DETECTOR_INVERTED;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Inverted Daylight Detector";
	}

	public function onActivate(Item $item, Player $player = null){
		$this->id = self::DAYLIGHT_DETECTOR;
		$this->getLevel()->setBlock($this, $this, true, false);
		$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_PLACE, $this->getPower());
		return true;
	}
}
