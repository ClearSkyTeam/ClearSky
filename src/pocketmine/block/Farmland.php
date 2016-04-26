<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\math\AxisAlignedBB;
use pocketmine\level\Level;

class Farmland extends Solid{

	protected $id = self::FARMLAND;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Farmland";
	}

	public function getHardness(){
		return 0.6;
	}

	public function getToolType(){
		return Tool::TYPE_SHOVEL;
	}

	public function getBoundingBox(){
		return new AxisAlignedBB(
			$this->x,
			$this->y,
			$this->z,
			$this->x + 1,
			$this->y + 0.9375,
			$this->z + 1
		);
	}

	public function getDrops(Item $item){
		return [
			[Item::DIRT, 0, 1],
		];
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			if($this->getSide(1)->isSolid()){
				$this->getLevel()->setBlock($this, new Dirt()); //todo any event to stop players from griefing farmland
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
}