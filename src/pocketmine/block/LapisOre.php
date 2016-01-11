<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class LapisOre extends Solid{

	protected $id = self::LAPIS_ORE;
	protected $exp_min = 2;
	protected $exp_max = 5;

	public function __construct(){

	}

	public function getHardness(){
		return 3;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName(){
		return "Lapis Lazuli Ore";
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_STONE){
			return [
				[Item::DYE, 4, mt_rand(4, 8)],
			];
		}else{
			return [];
		}
	}

}