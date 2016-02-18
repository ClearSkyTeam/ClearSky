<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class Glowstone extends Solid implements LightSource{

	protected $id = self::GLOWSTONE_BLOCK;

	public function __construct(){

	}
	
	public function isLightSource(){
		return true;
	}
	
	public function getName(){
		return "Glowstone";
	}

	public function getHardness(){
		return 0.3;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getLightLevel(){
		return 15;
	}

	public function getDrops(Item $item){
		return [
			[Item::GLOWSTONE_DUST, 0, mt_rand(2, 4)],
		];
	}
}