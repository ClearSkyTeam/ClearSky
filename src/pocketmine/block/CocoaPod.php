<?php

namespace pocketmine\block;

use pocketmine\event\block\BlockGrowEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\item\Dye;
use pocketmine\math\Vector3;
use pocketmine\math\AxisAlignedBB;

class CocoaPod extends Crops{
	protected $id = self::COCOA_POD;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Cocoa Block";
	}

	public function getHardness(){
		return 0.2;
	}

	public function getResistance(){
		return 15;
	}

	public function canBeActivated(){
		return true;
	}

	public function onActivate(Item $item, Player $player = null){
		if($item->getId() === Item::DYE and $item->getDamage() === Dye::BONEMEAL){
			$block = clone $this;
			$block->meta += 4;
			if($block->meta > 11){
				return false;
			}
			
			Server::getInstance()->getPluginManager()->callEvent($ev = new BlockGrowEvent($this, $block));
			
			if(!$ev->isCancelled()){
				$this->getLevel()->setBlock($this, $ev->getNewState(), true, true);
			}
			
			$item->count--;
			
			return true;
		}
		
		return false;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			$faces = array_flip(array(2 => 2, 3 => 4, 4 => 5, 5 => 3));
			if($this->getSide(Vector3::getOppositeSide($faces[($this->meta % 4) + 2]))->isTransparent() === true){
				$this->getLevel()->useBreakOn($this);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		elseif($type === Level::BLOCK_UPDATE_RANDOM){
			if(mt_rand(0, 2) === 1){
				if($this->meta < 8){
					$block = clone $this;
					$block->meta += 4;
					Server::getInstance()->getPluginManager()->callEvent($ev = new BlockGrowEvent($this, $block));
					if(!$ev->isCancelled()){
						$this->getLevel()->setBlock($this, $ev->getNewState(), true, true);
					}
					else{
						return Level::BLOCK_UPDATE_RANDOM;
					}
				}
			}
			else{
				return Level::BLOCK_UPDATE_RANDOM;
			}
		}
		return false;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		if($target->getId() === Block::WOOD and $target->getDamage() === Wood::JUNGLE){
			if($face !== 0 and $face !== 1){
				$faces = [2 => 0, 3 => 2, 4 => 3, 5 => 1];
				$this->meta = $faces[$face];
				$this->getLevel()->setBlock($block, $this, true);
				return true;
			}
		}
		return false;
	}

	public function getDrops(Item $item){
		$drops = [];
		if($this->meta >= 8){
			$drops[] = [Item::DYE, 3, 3];
		}
		else{
			$drops[] = [Item::DYE, 3, 1];
		}
		return $drops;
	}

	protected function recalculateBoundingBox(){
		if($this->meta % 4 === 0){
			$x1 = 0.25;
			$x2 = 0.75;
			$z1 = 0;
			$z2 = 0.5;
		}
		elseif($this->meta % 4 === 1){
			$x1 = 0.5;
			$x2 = 1;
			$z1 = 0.25;
			$z2 = 0.75;
		}
		elseif($this->meta % 4 === 2){
			$x1 = 0.25;
			$x2 = 0.75;
			$z1 = 0.5;
			$z2 = 1;
		}
		elseif($this->meta % 4 === 3){
			$x1 = 0;
			$x2 = 0.5;
			$z1 = 0.25;
			$z2 = 0.75;
		}
		return new AxisAlignedBB(
			$this->x + $x1,
			$this->y + 0.25,
			$this->z + $z1,
			$this->x + $x2,
			$this->y + 0.75,
			$this->z + $z2
		);
	}
}