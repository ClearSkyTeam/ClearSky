<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class Obsidian extends Solid{

	protected $id = self::OBSIDIAN;

	public function __construct(){

	}
	
	public function buildProtal(){
		for($i=0;)
	}

	public function getName(){
		return "Obsidian";
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getHardness(){
		return 35;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_DIAMOND){
			return [
				[Item::OBSIDIAN, 0, 1],
			];
		}else{
			return [];
		}
	}
}
