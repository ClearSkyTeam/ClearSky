<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\event\block\BlockGrowEvent;
use pocketmine\item\Dye;
use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\Server;

class NetherWart extends Crops{
	protected $id = self::NETHER_WART_BLOCK;
	
	public function __construct($meta = 0){
		$this->meta = $meta;
	}
	
	public function getName(){
		return "Nether Wart Block";
	}
	
	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $this->getSide(0);
		if($down->getId() === self::SOUL_SAND){
			$this->getLevel()->setBlock($block, $this, true, true);
			return true;
		}
		return false;
	}
	
	public function onActivate(Item $item, Player $player = null){
		if($item->getId() === Item::DYE and $item->getDamage() === Dye::BONEMEAL){
			$block = clone $this;
			$block->meta += mt_rand(2, 5);
			if($block->meta > 3){
				$block->meta = 3;
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
			if($this->getSide(0)->isTransparent() === true){
				$this->getLevel()->useBreakOn($this);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}elseif($type === Level::BLOCK_UPDATE_RANDOM){
			if(mt_rand(0, 2) == 1){
				if($this->meta < 0x03){
					$block = clone $this;
					++$block->meta;
					Server::getInstance()->getPluginManager()->callEvent($ev = new BlockGrowEvent($this, $block));

					if(!$ev->isCancelled()){
						$this->getLevel()->setBlock($this, $ev->getNewState(), true, true);
					}else{
						return Level::BLOCK_UPDATE_RANDOM;
					}
				}
			}else{
				return Level::BLOCK_UPDATE_RANDOM;
			}
		}

		return false;
	}

    public function getDrops(Item $item){
        $drops = [];
        if($this->meta >= 0x03){
            $drops[] = [Item::NETHER_WART, 0, mt_rand(2, 4)];
        }else{
            $drops[] = [Item::NETHER_WART, 0, 1];
        }

        return $drops;
	}
}
