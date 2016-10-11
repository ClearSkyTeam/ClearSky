<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\level\generator\object\Mushroom;
use pocketmine\utils\Random;

class BrownMushroom extends Flowable implements LightSource{

	protected $id = self::BROWN_MUSHROOM;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function canBeActivated(){
		return true;
	}

	public function getName(){
		return "Brown Mushroom";
	}

	public function getLightLevel(){
		return 1;
	}
	
	public function isLightSource(){
		return true;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $this->getSide(0);
		if($down->isTransparent() === false){
			$this->getLevel()->setBlock($block, $this, true, true);

			return true;
		}

		return false;
	}

	public function onActivate(Item $item, Player $player = null){
		if($item->getId() === Item::DYE and $item->getDamage() === 0x0F){ //Bonemeal
			//TODO: change log type
			Mushroom::growTree($this->getLevel(), $this->x, $this->y, $this->z, new Random($this->getLevel()->getSeed()), $this->id);
			if(($player->gamemode & 0x01) === 0){
				$item->count--;
			}

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
		}elseif($type === Level::BLOCK_UPDATE_RANDOM){ //Growth
			if(mt_rand(1, 7) === 1){
				if(($this->meta & 0x08) === 0x08){
					Mushroom::growTree($this->getLevel(), $this->x, $this->y, $this->z, new Random(mt_rand()), $this->id);
				}else{
					$this->meta |= 0x08;
					$this->getLevel()->setBlock($this, $this, true);

					return Level::BLOCK_UPDATE_RANDOM;
				}
			}else{
				return Level::BLOCK_UPDATE_RANDOM;
			}
		}

		return false;
	}

}