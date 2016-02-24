<?php
namespace pocketmine\item;

use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\block\Block;
use pocketmine\entity\TripoidCamera;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Enum;
use pocketmine\nbt\tag\Double;
use pocketmine\nbt\tag\Float;

class Camera extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::CAMERA, $meta, $count, "Camera");
	}
	
	public function canBeActivated(){
		return false;
	}/*
	
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$realPos = $target->getSide($face)->add(0.5, 0.4, 0.5);
		$camera = new TripoidCamera($player->getLevel()->getChunk($realPos->getX() >> 4, $realPos->getZ() >> 4), new Compound("", [
				"Pos" => new Enum("Pos", [
						new Double("", $realPos->getX()),
						new Double("", $realPos->getY()),
						new Double("", $realPos->getZ())
				]),
				"Motion" => new Enum("Motion", [
						new Double("", 0),
						new Double("", 0),
						new Double("", 0)
				]),
				"Rotation" => new Enum("Rotation", [
						new Float("", 0),
						new Float("", 0)
				]),
		]));
		$camera->spawnToAll();
		if($player->isSurvival()){
			--$this->count;
		}
	
		return true;
	}*/
}

