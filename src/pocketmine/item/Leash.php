<?php

namespace pocketmine\item;

use pocketmine\entity\Animal;
use pocketmine\entity\Entity;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\block\Block;
use pocketmine\entity\LeashKnot;
use pocketmine\block\Fence;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;

class Leash extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::LEAD, $meta, $count, "Leash");
	}

	public function useOnEntity(Entity $entity, Entity $origin){
		if($entity instanceof Animal){
			if($entity->isLeashableType()) $entity->setLeashHolder($origin);
		}
	}
	
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if(!$target instanceof Fence) return false;
		foreach ($level->getChunkEntities($target->x >> 4, $target->z >> 4) as $entity){
			if($entity->isLeashed()){
				if($entity->leadHolder === $player->getId()){
					$nbt = new CompoundTag("", [
						"Pos" => new ListTag("Pos", [
							new DoubleTag("", $block->getX() + 0.5),
							new DoubleTag("", $block->getY()),
							new DoubleTag("", $block->getZ() + 0.5)
						]),
						"Motion" => new ListTag("Motion", [
							new DoubleTag("", 0),
							new DoubleTag("", 0),
							new DoubleTag("", 0)
						]),
						"Rotation" => new ListTag("Rotation", [
							new FloatTag("", lcg_value() * 360),
							new FloatTag("", 0)
						])
					]);
					$level->addEntity($knot = new LeashKnot($level->getChunkAt($target->x >> 4, $target->z >> 4), $nbt));
					$entity->setLeashHolder($knot);
				}
			}
		}
	}
}
