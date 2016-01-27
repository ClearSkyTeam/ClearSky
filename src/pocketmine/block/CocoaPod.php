<?php

namespace pocketmine\block;

use pocketmine\event\block\BlockGrowEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3 as Vector3;
use pocketmine\Player;
use pocketmine\Server;

class CocoaPod extends Flowable{
	protected $id = self::COCOA;
	const SMALL = 0;
	const MEDIUM = 4;
	const LARGE = 8;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Cocoa Pod" . " facing " . $this->getFacing() . " " . $this->getSize();
	}

	public function getDrops(Item $item){
		if($this->getSize() === 8) return [[Item::COCOA_BEANS,0,3]];
		else return [[Item::COCOA_BEANS,0,1]];
	}

	public function onActivate(Item $item, Player $player = null){
		if($item->getId() === Item::DYE and $item->getDamage() === 0x0F){
			if($this->getSize() <= 8){
				$this->getLevel()->scheduleUpdate($this, 0);
			}
			
			return true;
		}
		
		return false;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			if($this->getSide($this->getAttachedFace())->getId() !== self::WOOD && $this->getSide($this->getAttachedFace())->getDamage() != Wood::JUNGLE){
				$this->getLevel()->useBreakOn($this);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		elseif($type === Level::BLOCK_UPDATE_RANDOM){
			if($this->getSize() <= 8){
				$this->getLevel()->scheduleUpdate($this, 0);
			}
		}
		elseif($type === Level::BLOCK_UPDATE_SCHEDULED){
			if($this->getSide($this->getAttachedFace())->getId() !== self::WOOD && $this->getSide($this->getAttachedFace())->getDamage() != Wood::JUNGLE){
				$sz = $this->getSize();
				if($sz >= 8) return false;
				elseif($sz === 4) $sz = 8;
				elseif($sz === 0) $sz = 4;
				else $sz = 0;
				Server::getInstance()->getPluginManager()->callEvent($ev = new BlockGrowEvent($this, new CocoaPod($sz)));
				if(!$ev->isCancelled()){
					$this->getLevel()->setBlock($this, new CocoaPod($sz), true);
					return Level::BLOCK_UPDATE_NORMAL;
				}
			}
		}
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		if($face !== 0 && $face !== 1 && $target->getId() === self::WOOD && $target->getDamage() === Wood::JUNGLE){
			$this->getLevel()->setBlock($block, Block::get(Block::COCOA, Vector3::getOppositeSide($target)));
			return true;
		}
		return false;
	}

	/**
	 * Get size of plant
	 *
	 * @return size
	 */
	public function getSize(){
		switch($this->meta & 0x0C){
			case 0:
				return CocoaPod::SMALL;
			case 4:
				return CocoaPod::MEDIUM;
			default:
				return CocoaPod::LARGE;
		}
	}

	/**
	 * Set size of plant
	 *
	 * @param $sz size        	
	 */
	public function setSize($sz){
		$dat = $this->meta & 0x03;
		switch($sz){
			case CocoaPod::SMALL:
				break;
			case CocoaPod::MEDIUM:
				$dat |= 0x04;
				break;
			case CocoaPod::LARGE:
				$dat |= 0x08;
				break;
		}
		$this->setDamage($dat);
	}

	public function getAttachedFace(){
		return Vector3::getOppositeSide($this->getFacing());
	}

	public function setFacingDirection($face){
		$dat = $this->meta & 0x0C;
		switch($face){
			default:
			case Vector3::SIDE_SOUTH:
				break;
			case Vector3::SIDE_WEST:
				$dat |= 0x01;
				break;
			case Vector3::SIDE_NORTH:
				$dat |= 0x02;
				break;
			case Vector3::SIDE_EAST:
				$dat |= 0x03;
				break;
		}
		$this->setDamage($dat);
	}

	public function getFacing(){
		switch($this->meta & 0x03){
			case 0:
				return Vector3::SIDE_SOUTH;
			case 1:
				return Vector3::SIDE_WEST;
			case 2:
				return Vector3::SIDE_NORTH;
			case 3:
				return Vector3::SIDE_EAST;
		}
		return null;
	}
}