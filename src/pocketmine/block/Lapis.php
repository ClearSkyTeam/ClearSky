<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class Lapis extends Solid{

	protected $id = self::LAPIS_BLOCK;

	public function __construct(){

	}

	public function getName(){
		return "Lapis Lazuli Block";
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
				[Item::LAPIS_BLOCK, 0, 1],
			];
		}else{
			return [];
		}
	}

}