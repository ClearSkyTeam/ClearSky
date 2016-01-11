<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class RedMushroomBlock extends Solid{

	protected $id = self::RED_MUSHROOM_BLOCK;

	public function __construct($meta = 15){
		$this->meta = $meta;
	}

	public function getToolType(){
		return Tool::TYPE_AXE;
	}

	public function getName(){
		return "Red Mushroom Block";
	}

	public function getHardness(){
		return 0.1;
	}

	public function getDrops(Item $item){
		$drops = [];
		if(mt_rand(1, 20) === 1){ //Red Mushrooms
			$drops[] = [Item::RED_MUSHROOM, $this->meta & 0x03, 1];
		}
		return $drops;
	}
}