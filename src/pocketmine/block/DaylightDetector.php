<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\math\AxisAlignedBB;
use pocketmine\tile\DLDetector;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\tile\Tile;

class DaylightDetector extends Transparent implements Redstone, RedstoneSwitch, RedstoneSource{
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

	public function isRedstoneSource(){
		return true;
	}

	public function isPowered(){
		return true;
	}

	public function canBeActivated(){
		return true;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$this->getLevel()->setBlock($block, $this, true, false);
		$nbt = new CompoundTag("", [new StringTag("id", Tile::DAY_LIGHT_DETECTOR), new IntTag("x", $this->x), new IntTag("y", $this->y), new IntTag("z", $this->z)]);
		
		Tile::createTile(Tile::DAY_LIGHT_DETECTOR, $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);
		return true;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_SCHEDULED || $type === Level::BLOCK_UPDATE_NORMAL){
			$this->getLevel()->scheduleUpdate($this, 50);
			$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_PLACE, $this->getPower());
		}
		return false;
	}

	public function onActivate(Item $item, Player $player = null){
		$this->id = self::DAYLIGHT_DETECTOR_INVERTED;
		$this->getLevel()->setBlock($this, $this, true, false);
		$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_PLACE, $this->getPower());
		return true;
	}

	public function getDrops(Item $item){
		return [[self::DAYLIGHT_DETECTOR, 0, 1]];
	}

	public function getPower(){
		return $this->getLevel()->getTile($this) instanceof DLDetector?($this->getId() == self::DAYLIGHT_DETECTOR?$this->getLevel()->getTile($this)->getPower():16 - (16 - $this->getLevel()->getTile($this)->getPower())):0;
	}

	protected function recalculateBoundingBox(){
		return new AxisAlignedBB($this->x, $this->y, $this->z, $this->x + 1, $this->y + 0.375, $this->z + 1);
	}
}
