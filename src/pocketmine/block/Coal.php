<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class Coal extends Solid{

	protected $id = self::COAL_BLOCK;

	public function __construct(){

	}

	public function getHardness(){
		return 5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName(){
		return "Coal Block";
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[Item::COAL_BLOCK, 0, 1],
			];
		}else{
			return [];
		}
	}
}