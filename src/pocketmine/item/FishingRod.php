<?php
namespace pocketmine\item;


use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\entity\FishingHook;
class FishingRod extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::FISHING_ROD, 0, $count, "Fishing Rod");
	}

	public function getMaxStackSize(){
		return 1;
	}

	/*public function canBeActivated(){
		return true;
	}
	
	public function onActivate(Level $level, Player $player, $block, $target, $face, $fx, $fy, $fz){
		foreach($player->getLevel()->getEntities() as $entity){
			if($entity instanceof FishingHook){
				if($entity->shootingEntity === $player) $entity->reelLine();
			}
		}
	}*/
}