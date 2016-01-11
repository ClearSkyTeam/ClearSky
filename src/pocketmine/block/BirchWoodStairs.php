<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class BirchWoodStairs extends Stair{

	protected $id = self::BIRCH_WOOD_STAIRS;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Birch Wood Stairs";
	}

	public function getDrops(Item $item){
		return [
			[$this->id, 0, 1],
		];
	}

	public function getHardness(){
		return 2;
	}

	public function getResistance(){
		return 15;
	}

	public function getToolType(){
		return Tool::TYPE_AXE;
	}
}