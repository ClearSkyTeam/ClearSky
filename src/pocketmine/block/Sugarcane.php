<?php

namespace pocketmine\block;

use pocketmine\event\block\BlockGrowEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\item\Dye;

class Sugarcane extends Flowable{
	protected $id = self::SUGARCANE_BLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Sugarcane";
	}

	public function getDrops(Item $item){
		return [
			[Item::SUGARCANE, 0, 1],
		];
	}

	public function onActivate(Item $item, Player $player = null){
		if($item->getId() === Item::DYE and $item->getDamage() === Dye::BONEMEAL){
			$grow = false;
			if($this->getSide(0)->getId() !== self::SUGARCANE_BLOCK && $this->getSide(0, 2)->getId() !== self::SUGARCANE_BLOCK){
				for($y = 1; $y < 2; $y++){
					$b = $this->getSide(1, $y);
					if($b->getId() === self::AIR){
						Server::getInstance()->getPluginManager()->callEvent($ev = new BlockGrowEvent($b, new Sugarcane()));
						if(!$ev->isCancelled()){
							$this->getLevel()->setBlock($b, $ev->getNewState(), true);
							$grow = true;
						}
						break;
					}
					else{
						break;
					}
				}
				$this->meta = 0;
				$this->getLevel()->setBlock($this, $this, true);
			}
			if($grow && $player->isSurvival()){
				$item->count--;
			}
			
			return true;
		}
		
		return false;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			$down = $this->getSide(0);
			$up = $this->getSide(1);
			if(!in_array($this->getSide(0)->getId(), array(self::SAND, self::DIRT, self::GRASS, self::SUGARCANE_BLOCK))){
				$this->getLevel()->scheduleUpdate($this, 0);
			}
			else{
				for($side = 2; $side <= 5; ++$side){
					$b = $this->getSide($side);
					if(!$b->canBeFlowedInto()){
						$this->getLevel()->useBreakOn($this);
					}
				}
			}
		}
		elseif($type === Level::BLOCK_UPDATE_RANDOM){
			if(!in_array($this->getSide(0)->getId(), array(self::SAND, self::DIRT, self::GRASS, self::SUGARCANE_BLOCK))){
				$this->getLevel()->scheduleUpdate($this, 0);
			}
			elseif($this->getSide(1)->getId() === self::AIR){
				if($this->meta === 15){
					if(!($this->getSide(0)->getId() === self::SUGARCANE_BLOCK && $this->getSide(0, 2)->getId() === self::SUGARCANE_BLOCK)){
						$b = $this->getSide(1);
						Server::getInstance()->getPluginManager()->callEvent($ev = new BlockGrowEvent($b, new Sugarcane()));
						if(!$ev->isCancelled()){
							$this->getLevel()->setBlock($b, $ev->getNewState(), true);
						}
						$this->meta = 0;
					}
					$this->getLevel()->setBlock($this, $this);
				}
				else{
					++$this->meta;
					$this->getLevel()->setBlock($this, $this);
				}
			}
		}
		elseif($type === Level::BLOCK_UPDATE_SCHEDULED){
			$this->getLevel()->useBreakOn($this);
		}
		
		return false;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $this->getSide(0);
		if($down->getId() === self::SUGARCANE_BLOCK){
			$this->getLevel()->setBlock($block, new Sugarcane(), true);
			
			return true;
		}
		elseif($down->getId() === self::GRASS or $down->getId() === self::DIRT or $down->getId() === self::SAND){
			$block0 = $down->getSide(2);
			$block1 = $down->getSide(3);
			$block2 = $down->getSide(4);
			$block3 = $down->getSide(5);
			if(($block0 instanceof Water) or ($block1 instanceof Water) or ($block2 instanceof Water) or ($block3 instanceof Water)){
				$this->getLevel()->setBlock($block, new Sugarcane(), true);
				
				return true;
			}
		}
		
		return false;
	}
}