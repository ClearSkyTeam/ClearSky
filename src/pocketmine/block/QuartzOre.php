<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class QuartzOre extends Solid{

	protected $id = self::QUARTZ_ORE;
	protected $exp_min = 2;
	protected $exp_max = 5;
	public $exp_smelt = 0.2;

	public function __construct(){

	}

	public function getName(){
		return "Nether Quartz Ore";
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
				[Item::QUARTZ, 0, mt_rand(4, 8)],
			];
		}else{
			return [];
		}
	}
}