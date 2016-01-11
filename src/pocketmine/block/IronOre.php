<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class IronOre extends Solid{

	protected $id = self::IRON_ORE;
	public $smeltingExp = 0.7;

	public function __construct(){

	}

	public function getName(){
		return "Iron Ore";
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getHardness(){
		return 3;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_STONE){
			return [
				[Item::IRON_ORE, 0, 1],
			];
		}else{
			return [];
		}
	}
}