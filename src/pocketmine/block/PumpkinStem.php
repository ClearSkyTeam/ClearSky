<?php
namespace pocketmine\block;

use pocketmine\event\block\BlockGrowEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Server;

class PumpkinStem extends Crops{

	protected $id = self::PUMPKIN_STEM;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Pumpkin Stem";
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->isTransparent()){
				$this->getLevel()->useBreakOn($this);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}elseif($type === Level::BLOCK_UPDATE_RANDOM){
			if(mt_rand(0, 2) == 1){
				if($this->meta < 0x07){
					$block = clone $this;
					++$block->meta;
					Server::getInstance()->getPluginManager()->callEvent($ev = new BlockGrowEvent($this, $block));
					if(!$ev->isCancelled()){
						$this->getLevel()->setBlock($this, $ev->getNewState(), true);
					}

					return Level::BLOCK_UPDATE_RANDOM;
				}else{
					for($side = 2; $side <= 5; ++$side){
						$b = $this->getSide($side);
						if($b->getId() === self::PUMPKIN){
							return Level::BLOCK_UPDATE_RANDOM;
						}
					}
					$side = $this->getSide(mt_rand(2, 5));
					$d = $side->getSide(0);
					if($side->getId() === self::AIR and ($d->getId() === self::FARMLAND or $d->getId() === self::GRASS or $d->getId() === self::DIRT)){
						Server::getInstance()->getPluginManager()->callEvent($ev = new BlockGrowEvent($side, new Pumpkin()));
						if(!$ev->isCancelled()){
							$this->getLevel()->setBlock($side, $ev->getNewState(), true);
						}
					}
				}
			}

			return Level::BLOCK_UPDATE_RANDOM;
		}

		return false;
	}

	public function getDrops(Item $item){
		return [
			[Item::PUMPKIN_SEEDS, 0, mt_rand(0, 2)],
		];
	}
}