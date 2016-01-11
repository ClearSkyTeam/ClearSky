<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class Gold extends Solid{

	protected $id = self::GOLD_BLOCK;

	public function __construct(){

	}

	public function getName(){
		return "Gold Block";
	}

	public function getHardness(){
		return 3;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_IRON){
			return [
				[Item::GOLD_BLOCK, 0, 1],
			];
		}else{
			return [];
		}
	}
}