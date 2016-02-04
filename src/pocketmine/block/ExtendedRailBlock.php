<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\math\Vector3;

abstract class ExtendedRailBlock extends RailBlock{

	public function setDirection($face, $isOnSlope = false){
		$extrabitset = (($this->meta & 0x08) === 0x08);
		if($face !== Vector3::SIDE_WEST && $face !== Vector3::SIDE_EAST && $face !== Vector3::SIDE_NORTH && $face !== Vector3::SIDE_SOUTH){
			throw new IllegalArgumentException("This rail variant can't be on a curve!");
		}
		$this->meta = ($extrabitset?($this->meta | 0x08):($this->meta & ~0x08));
		$this->getLevel()->setBlock($this, Block::get($this->id, $this->meta));
	}

	public function isCurve(){
		return false;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $block->getSide(Vector3::SIDE_DOWN);
		if($down->isTransparent() === false	|| ($down instanceof Slab && ($down->meta & 0x08) === 0x08) || ($down instanceof WoodSlab && ($down->meta & 0x08) === 0x08) || ($down instanceof Stair && ($down->meta & 0x04) === 0x04)){
			$this->getLevel()->setBlock($this, Block::get($this->id, 0));
			$up = $block->getSide(Vector3::SIDE_UP);
			if($block->getSide(Vector3::SIDE_EAST) instanceof RailBlock && $block->getSide(Vector3::SIDE_WEST) instanceof RailBlock){
				if($up->getSide(Vector3::SIDE_EAST) instanceof RailBlock){
					$this->setDirection(Vector3::SIDE_EAST, true);
				}
				elseif($up->getSide(Vector3::SIDE_WEST) instanceof RailBlock){
					$this->setDirection(Vector3::SIDE_WEST, true);
				}
				else{
					$this->setDirection(Vector3::SIDE_EAST);
				}
			}
			elseif($block->getSide(Vector3::SIDE_SOUTH) instanceof RailBlock && $block->getSide(Vector3::SIDE_NORTH) instanceof RailBlock){
				if($up->getSide(Vector3::SIDE_SOUTH) instanceof RailBlock){
					$this->setDirection(Vector3::SIDE_SOUTH, true);
				}
				elseif($up->getSide(Vector3::SIDE_NORTH) instanceof RailBlock){
					$this->setDirection(Vector3::SIDE_NORTH, true);
				}
				else{
					$this->setDirection(Vector3::SIDE_SOUTH);
				}
			}
			else{
				$this->setDirection(Vector3::SIDE_NORTH);
			}
			return true;
		}
		return false;
	}
}