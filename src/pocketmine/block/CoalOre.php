<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class CoalOre extends Solid{

	protected $id = self::COAL_ORE;
	protected $exp_min = 0;
	protected $exp_max = 2;
	public $smeltingExp = 0.1;

	public function __construct(){

	}

	public function getHardness(){
		return 3;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName(){
		return "Coal Ore";
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[Item::COAL, 0, 1],
			];
		}else{
			return [];
		}
	}

}