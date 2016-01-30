<?php

namespace pocketmine\item;

use pocketmine\level\Level;
use pocketmine\block\Block;
use pocketmine\Player;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\entity\Minecart as MinecartEntity;
use pocketmine\math\Vector3;
use pocketmine\block\Rail;

class Minecart extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::MINECART, $meta, $count, "Minecart");
	}

	public function getMaxStackSize(){
		return 1;
	}

	public function canBeActivated(){
		return true;
	}

	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		/*$realPos = $block->getSide(Vector3::SIDE_UP);
		if(!$block instanceof Rail) return false;
		$cart = new MinecartEntity($player->getLevel()->getChunk($realPos->getX() >> 4, $realPos->getZ() >> 4), new CompoundTag("", ["Pos" => new ListTag("Pos", [new DoubleTag("", $realPos->getX()),new DoubleTag("", $realPos->getY()),new DoubleTag("", $realPos->getZ())]),
				"Motion" => new ListTag("Motion", [new DoubleTag("", 0),new DoubleTag("", 0),new DoubleTag("", 0)]),"Rotation" => new ListTag("Rotation", [new FloatTag("", 0),new FloatTag("", 0)])]));
		$cart->spawnToAll();
		
		if($player->isSurvival()){
			$item = $player->getInventory()->getItemInHand();
			$count = $item->getCount();
			if(--$count <= 0){
				$player->getInventory()->setItemInHand(Item::get(Item::AIR));
				return;
			}
			
			$item->setCount($count);
			$player->getInventory()->setItemInHand($item);
		}
		*/
		return true;
	}
}