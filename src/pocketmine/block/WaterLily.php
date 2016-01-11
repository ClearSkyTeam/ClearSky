<?php
namespace pocketmine\block;


use pocketmine\item\Item;

use pocketmine\level\Level;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\Player;

class WaterLily extends Flowable{

	protected $id = self::WATER_LILY;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function isSolid(){
		return false;
	}

	public function getName(){
		return "Lily Pad";
	}

	public function getHardness(){
		return 0.6;
	}

	public function canPassThrough(){
		return false;
	}

	protected function recalculateBoundingBox(){
		return new AxisAlignedBB(
			$this->x,
			$this->y,
			$this->z,
			$this->x,
			$this->y + 0.0625,
			$this->z
		);
	}


	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		if($target instanceof Water){
			$up = $target->getSide(Vector3::SIDE_UP);
			if($up->getId() === Block::AIR){
				$this->getLevel()->setBlock($up, $this, true, true);
				return true;
			}
		}

		return false;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			if(!($this->getSide(0) instanceof Water)){
				$this->getLevel()->useBreakOn($this);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}

		return false;
	}

	public function getDrops(Item $item){
		return [
			[$this->id, 0, 1]
		];
	}
}