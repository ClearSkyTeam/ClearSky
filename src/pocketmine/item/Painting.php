<?php
namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\entity\Painting as PaintingEntity;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\math\Vector3;

class Painting extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::PAINTING, 0, $count, "Painting");
	}

	public function canBeActivated(){
		return true;
	}
	
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if($target->isTransparent() === false and $face !== 0 and $face !== 1 and $block->isSolid() === false){
			$faces = [
				2 => 1,
				3 => 3,
				4 => 0,
				5 => 2,
			];
			
			$motives = PaintingEntity::MOTIVES;
			
			$face2side = [4, 5, 3, 2];
			
			$foundApplicableMotive = false;
			$searchedMotives = [];
			while(!$foundApplicableMotive){
				if(count($searchedMotives) == count($motives)){
					break;
				}
				$rand = -1;
				while(!isset($motives[$rand])){
					$rand = mt_rand(0, count($motives) - 1);
				}
				$motive = $motives[$rand];
				$foundApplicableMotive = true;
				$searchedMotives[$rand] = true;
				for($x = 0; $x < $motive[1] && $foundApplicableMotive; $x++){
					for($z = 0; $z < $motive[2] && $foundApplicableMotive; $z++){
						if($target->getSide($face2side[$face - 2], $x)->isTransparent() ||
							$target->getSide(Vector3::SIDE_UP, $z)->isTransparent() ||
							$block->getSide($face2side[$face - 2], $x)->isSolid() ||
							$block->getSide(Vector3::SIDE_UP, $z)->isSolid()
						){
							$foundApplicableMotive = false;
						}
					}
				}
			}
			if(!$foundApplicableMotive){
				return false;
			}
			
			//WIP overlapping calculation AND BTW: EVEN MCPE DOESN'T DO THIS!
			/*
			for($x = 0; $x < $motive[1] && $valid; $x++){
				for($z = 0; $z < $motive[2] && $valid; $z++){
					$entPos = $target->getSide($right[$face - 2], $x);
					//getEntitiesAtThatPos (high intensive calculation)
					if($entity instanceof PaintingEntity){
						return false;
					}
				}
			}
			*/
			
			$data = [
				"x" => $target->x,
				"y" => $target->y - 0.1,
				"z" => $target->z,
				"yaw" => $faces[$face] * 90,
				"Motive" => $motive[0],
			];
			if($motive[2] <= 1){
				$data["y"] = $data["y"] + 1;
			}
			if($motive[2] >= 2){
				$data["y"] = $data["y"] + 0.4;
			}
			if($motive[2] >= 3){
				$data["y"] = $data["y"] + 0.1;
			}
			switch($face2side[$face - 2]){
				case Vector3::SIDE_NORTH:
					$data["z"] = $data["z"] + 0.1;
				break;
				case Vector3::SIDE_SOUTH:
					$data["z"] = $data["z"] - 0.1;
				break;
				case Vector3::SIDE_WEST:
					$data["x"] = $data["x"] + 0.1;
				break;
				case Vector3::SIDE_EAST:
					$data["x"] = $data["x"] - 0.1;
				break;
			}
			
			$nbt = new CompoundTag("", [
				"Motive" => new StringTag("Motive", $data["Motive"]),
				"Pos" => new ListTag("Pos", [
					new DoubleTag("", $data["x"]),
					new DoubleTag("", $data["y"]),
					new DoubleTag("", $data["z"])
				]),
				"Motion" => new ListTag("Motion", [
					new DoubleTag("", 0),
					new DoubleTag("", 0),
					new DoubleTag("", 0)
				]),
				"Rotation" => new ListTag("Rotation", [
					new FloatTag("", $data["yaw"]),
					new FloatTag("", 0)
				]),
			]);
			
			$painting = new PaintingEntity($player->getLevel()->getChunk($block->getX() >> 4, $block->getZ() >> 4), $nbt);
			$painting->spawnToAll();
			unset($player->getLevel()->updateEntities[$painting->getId()]);
			
			if($player->isSurvival()){
				$item = $player->getInventory()->getItemInHand();
				$count = $item->getCount();
				if(--$count <= 0){
					$player->getInventory()->setItemInHand(Item::get(Item::AIR));
				}

				$item->setCount($count);
				$player->getInventory()->setItemInHand($item);
			}

			return true;
		}

		return false;
	}

}
