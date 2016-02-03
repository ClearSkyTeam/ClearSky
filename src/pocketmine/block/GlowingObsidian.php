<?php
namespace pocketmine\block;

use pocketmine\item\Item; 
use pocketmine\item\Tool; 

class GlowingObsidian extends Solid{

	protected $id = self::GLOWING_OBSIDIAN;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Glowing Obsidian";
	}
	
	public function getHardness(){
		return 6;
	}

	public function getLightLevel(){
		return 12;
	}
	
	public function getToolType(){ 
 		return Tool::TYPE_PICKAXE; 
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
