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
		if($down->isTransparent() === false){
			$this->calculateDirection($block);
			return true;
		}
		return false;
	}
	
	public function calculateDirection(Block $block){
		$up = $block->getSide(Vector3::SIDE_UP);//slopes
		if($block->getSide(Vector3::SIDE_NORTH) instanceof RailBlock && $up->getSide(Vector3::SIDE_SOUTH) instanceof RailBlock){
			$this->setDirection(Vector3::SIDE_SOUTH, true);
		}elseif($block->getSide(Vector3::SIDE_WEST) instanceof RailBlock && $up->getSide(Vector3::SIDE_EAST) instanceof RailBlock){
			$this->setDirection(Vector3::SIDE_EAST, true);
		}elseif($block->getSide(Vector3::SIDE_SOUTH) instanceof RailBlock && $up->getSide(Vector3::SIDE_NORTH) instanceof RailBlock){
			$this->setDirection(Vector3::SIDE_NORTH, true);
		}elseif($block->getSide(Vector3::SIDE_EAST) instanceof RailBlock && $up->getSide(Vector3::SIDE_WEST) instanceof RailBlock){
			$this->setDirection(Vector3::SIDE_WEST, true);
		}//line 2 attached
		elseif($block->getSide(Vector3::SIDE_SOUTH) instanceof RailBlock && $block->getSide(Vector3::SIDE_NORTH) instanceof RailBlock){
			$this->setDirection(Vector3::SIDE_NORTH);
		}elseif($block->getSide(Vector3::SIDE_EAST) instanceof RailBlock && $block->getSide(Vector3::SIDE_WEST) instanceof RailBlock){
			$this->setDirection(Vector3::SIDE_WEST);
		}// 1 attached
		elseif($block->getSide(Vector3::SIDE_SOUTH) instanceof RailBlock){
			$this->setDirection(Vector3::SIDE_SOUTH);
		}elseif($block->getSide(Vector3::SIDE_EAST) instanceof RailBlock){
			$this->setDirection(Vector3::SIDE_EAST);
		}elseif($block->getSide(Vector3::SIDE_NORTH) instanceof RailBlock){
			$this->setDirection(Vector3::SIDE_NORTH);
		}elseif($block->getSide(Vector3::SIDE_WEST) instanceof RailBlock){
			$this->setDirection(Vector3::SIDE_WEST);
		}else{
			$this->setDirection(Vector3::SIDE_SOUTH);
		}
		for($i = Vector3::SIDE_NORTH; $i < Vector3::SIDE_EAST; $i++){
			$pos = $block->getSide($i);
			if($pos instanceof RailBlock){
				$this->getLevel()->scheduleUpdate($pos, 0);
			}
			$pos = $block->getSide(Vector3::SIDE_DOWN)->getSide($i);
			if($pos instanceof RailBlock){
				$this->getLevel()->scheduleUpdate($pos, 0);
			}
			$pos = $block->getSide(Vector3::SIDE_UP)->getSide($i);
			if($pos instanceof RailBlock){
				$this->getLevel()->scheduleUpdate($pos, 0);
			}
		}
	}
}