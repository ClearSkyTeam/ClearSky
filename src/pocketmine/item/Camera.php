<?php
namespace pocketmine\item;

use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\block\Block;
use pocketmine\entity\TripoidCamera;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;

class Camera extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::CAMERA, $meta, $count, "Camera");
	}
	
	public function canBeActivated(){
		return false;
	}/*
	
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$realPos = $target->getSide($face)->add(0.5, 0.4, 0.5);
		$camera = new TripoidCamera($player->getLevel()->getChunk($realPos->getX() >> 4, $realPos->getZ() >> 4), new CompoundTag("", [
				"Pos" => new ListTag("Pos", [
						new DoubleTag("", $realPos->getX()),
						new DoubleTag("", $realPos->getY()),
						new DoubleTag("", $realPos->getZ())
				]),
				"Motion" => new ListTag("Motion", [
						new DoubleTag("", 0),
						new DoubleTag("", 0),
						new DoubleTag("", 0)
				]),
				"Rotation" => new ListTag("Rotation", [
						new FloatTag("", 0),
						new FloatTag("", 0)
				]),
		]));
		$camera->spawnToAll();
		if($player->isSurvival()){
			--$this->count;
		}
	
		return true;
	}*/
}

