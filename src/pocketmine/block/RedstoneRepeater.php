<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\math\AxisAlignedBB;

class RedstoneRepeater extends Flowable implements Redstone, RedstoneTransmitter{
	protected $id = self::UNPOWERED_REPEATER;

	public function isRedstone(){
		return true;
	}

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function recalculateBoundingBox(){
		return new AxisAlignedBB(
			$this->x,
			$this->y,
			$this->z,
			$this->x + 1,
			$this->y + 0.125,
			$this->z + 1
		);
	}
	
	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		if($target->isTransparent() === false){
			$faces = [
				2 => 3,
				3 => 0,
				0 => 1,
				1 => 2,
			];
			$this->meta = $faces[$player instanceof Player?$player->getDirection():0];
			$this->getLevel()->setBlock($block, $this, true, true);
			return true;
		}
		return false;
	}
	
}