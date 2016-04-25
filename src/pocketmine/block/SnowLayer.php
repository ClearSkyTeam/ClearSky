<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\level\Level;
use pocketmine\Player;

class SnowLayer extends Flowable{

	protected $id = self::SNOW_LAYER;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Snow Layer";
	}

	public function canBeReplaced(){
		return true;
	}

	public function getHardness(){
		return 0.1;
	}

	public function getToolType(){
		return Tool::TYPE_SHOVEL;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $this->getSide(0);
		if($down->isSolid()){
			if($down->getId() === $this->getId() && $down->getDamage() <= 7){
				if($down->getDamage() === 7){
				$this->getLevel()->setBlock($down, new Snow(), true);	
				} else {
				$down->setDamage($down->getDamage() + 1);
				$this->getLevel()->setBlock($down, $down, true);
				}
				return true;
			}else{
				$this->getLevel()->setBlock($block, $this, true);
				
				return true;
			}
		}
		
		return false;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->getId() === self::AIR){ // Replace with common break method
				$this->getLevel()->setBlock($this, new Air(), true);
				
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		elseif($type === Level::BLOCK_UPDATE_RANDOM){ // added melting
			if($this->getLevel()->getBlockLightAt($this->x, $this->y, $this->z) >= 10){
				$this->getLevel()->setBlock($this, new Air(), true);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		
		return false;
	}

	public function getDrops(Item $item){
		if($item->isShovel() !== false){
			return [[Item::SNOWBALL,0,$this->getDamage() + 1]]; // Amount in PC version is based on the number of layers
		}
		
		return [];
	}

	protected function recalculateBoundingBox(){
		return new AxisAlignedBB(
			$this->x,
			$this->y,
			$this->z,
			$this->x + 1,
			$this->y + 0.125 + (0.125 * $this->meta),
			$this->z + 1
		);
	}
}
