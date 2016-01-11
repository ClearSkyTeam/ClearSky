<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class DiamondOre extends Solid{

	protected $id = self::DIAMOND_ORE;
	protected $exp_min = 3;
	protected $exp_max = 7;
	public $smeltingExp = 1;

	public function __construct(){

	}

	public function getHardness(){
		return 3;
	}
	
	public function getExperience(){
		return mt_rand(3, 7);
	}
	
	public function getName(){
		return "Diamond Ore";
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_IRON){
			return [
				[Item::DIAMOND, 0, 1],
			];
		}else{
			return [];
		}
	}
}