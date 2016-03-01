<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\Player;

class EndPortalFrame extends Solid implements LightSource{

	protected $id = self::END_PORTAL_FRAME;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getLightLevel(){
		return 1;
	}
	
	public function isLightSource(){
		return true;
	}

	public function getName(){
		return "End Portal Frame";
	}

	public function getHardness(){
		return -1;
	}

	public function getResistance(){
		return 18000000;
	}

	public function isBreakable(Item $item){
		return false;
	}

	protected function recalculateBoundingBox(){
		return new AxisAlignedBB(
			$this->x,
			$this->y,
			$this->z,
			$this->x + 1,
			$this->y + (($this->getDamage() & 0x04) > 0 ? 1 : 0.8125),
			$this->z + 1
		);
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$faces = [
			0 => 3,
			1 => 2,
			2 => 1,
			3 => 0
		];
		$this->meta = $faces[$player instanceof Player ? $player->getDirection() : 0] & 0x01;
		$this->getLevel()->setBlock($block, $this, true, true);

		return true;
	}

	//TODO Implement ender portal when implemented on client
}