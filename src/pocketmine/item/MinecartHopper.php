<?php

namespace pocketmine\item;

use pocketmine\level\Level;
use pocketmine\block\Block;
use pocketmine\Player;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\entity\MinecartHopper as MinecartHopperEntity;

class MinecartHopper extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::HOPPER_MINECART, $meta, $count, "Hopper Minecart");
	}
	
	public function getMaxStackSize(){
		return 1;
	}
	
	public function canBeActivated(){
		return true;
	}

	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if(!in_array($target->getId(),array(Block::RAIL, Block::ACTIVATOR_RAIL, Block::DETECTOR_RAIL, Block::POWERED_RAIL))) return false;
		$realPos = $target->add(0.5, 0, 0.5);
		$cart = new MinecartHopperEntity($player->getLevel()->getChunk($realPos->getX() >> 4, $realPos->getZ() >> 4), new Compound("", [
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
		$cart->spawnToAll();
		if($player->isSurvival()){
			--$this->count;
		}
		
		return true;
	}
}