<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class Bricks extends Solid{

	protected $id = self::BRICKS_BLOCK;

	public function __construct(){

	}

	public function getHardness(){
		return 2;
	}

	public function getResistance(){
		return 30;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName(){
		return "Bricks";
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[Item::BRICKS_BLOCK, 0, 1],
			];
		}else{
			return [];
		}
	}
}