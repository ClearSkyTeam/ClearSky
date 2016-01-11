<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class EmeraldOre extends Solid{

	protected $id = self::EMERALD_ORE;
	protected $exp_min = 3;
	protected $exp_max = 7;
	public $smeltingExp = 1;

	public function __construct(){

	}

	public function getName(){
		return "Emerald Ore";
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getHardness(){
		return 3;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_IRON){
			return [
				[Item::EMERALD, 0, 1],
			];
		}else{
			return [];
		}
	}
}