<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;

class Torch extends Flowable{
	protected $id = self::TORCH;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getLightLevel(){
		return 15;
	}
	
	public function isLightSource(){
		return true;
	}

	public function getName(){
		return "Torch";
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			$below = $this->getSide(0);
			$side = $this->getDamage();
			$faces = [1 => 4,2 => 5,3 => 2,4 => 3,5 => 0,6 => 0,0 => 0];
			
			if($this->getSide($faces[$side])->isTransparent() === true and !($side === 0 and ($below instanceof Fence or $below->getId() === self::COBBLE_WALL or $below->getId() === self::GLASS || ($below instanceof Slab && ($below->meta & 0x08) === 0x08) || ($below instanceof WoodSlab && ($below->meta & 0x08) === 0x08) || ($below instanceof Stair && ($below->meta & 0x04) === 0x04)))){
				$this->getLevel()->useBreakOn($this);
				
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		
		return false;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$below = $this->getSide(0);
		
		if($target->isTransparent() === false and $face !== 0){
			$faces = [1 => 5,2 => 4,3 => 3,4 => 2,5 => 1];
			$this->meta = $faces[$face];
			$this->getLevel()->setBlock($block, $this, true, true);
			
			return true;
		}
		elseif($below->isTransparent() === false or $below instanceof Fence or $below->getId() === self::COBBLE_WALL or $below->getId() === self::GLASS || ($below instanceof Slab && ($below->meta & 0x08) === 0x08) || ($below instanceof WoodSlab && ($below->meta & 0x08) === 0x08) || ($below instanceof Stair && ($below->meta & 0x04) === 0x04)){
			$this->meta = 0;
			$this->getLevel()->setBlock($block, $this, true, true);
			
			return true;
		}
		
		return false;
	}

	public function getDrops(Item $item){
		return [[$this->id,0,1]];
	}
}