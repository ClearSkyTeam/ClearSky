<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class IronBars extends Thin{

	protected $id = self::IRON_BARS;

	public function __construct(){

	}

	public function getName(){
		return "Iron Bars";
	}

	public function getHardness(){
		return 5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[Item::IRON_BARS, 0, 1],
			];
		}else{
			return [];
		}
	}

}

