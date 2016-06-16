<?php

namespace pocketmine\block;

use pocketmine\entity\Effect;
use pocketmine\event\entity\EntityEatBlockEvent;
use pocketmine\item\FoodSource;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\AxisAlignedBB;
use pocketmine\Player;

class Cake extends Transparent implements FoodSource{

	protected $id = self::CAKE_BLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function canBeActivated(){
		return true;
	}

	public function getHardness(){
		return 0.5;
	}

	public function getName(){
		return "Cake Block";
	}

	protected function recalculateBoundingBox(){
		$f = (1 + $this->getDamage() * 2) / 16;
		
		return new AxisAlignedBB(
			$this->x + $f,
			$this->y,
			$this->z + 0.0625,
			$this->x + 0.9375,
			$this->y + 0.5,
			$this->z + 0.9375
		);
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $this->getSide(0);
		if($down->getId() !== self::AIR){
			$this->getLevel()->setBlock($block, $this, true, true);
			
			return true;
		}
		
		return false;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->isTransparent()){
				$this->getLevel()->useBreakOn($this);
				
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		
		return false;
	}

	public function getDrops(Item $item){
		return [];
	}

	public function onActivate(Item $item, Player $player = null){
		if($player instanceof Player and $player->getHealth() < $player->getMaxHealth()){
			$ev = new EntityEatBlockEvent($player, $this);

			if(!$ev->isCancelled()){
				$this->getLevel()->setBlock($this, $ev->getResidue());
				return true;
			}
		}

		return false;
	}

	public function getFoodRestore(){
		return 2;
	}

	public function getSaturationRestore(){
		return 0.4;
	}

	public function getResidue(){
		$clone = clone $this;
		$clone->meta++;
		if($clone->meta >= 0x06){
			$clone = new Air();
		}
		return $clone;
	}

	/**
	 * @return Effect[]
	 */
	public function getAdditionalEffects(){
		return [];
	}
}