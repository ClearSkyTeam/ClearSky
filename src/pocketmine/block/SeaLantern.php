<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class SeaLantern extends Transparent implements LightSource{

	protected $id = Item::SEA_LANTERN;

	public function __construct(){

	}
	
	public function isLightSource(){
		return true;
	}

	public function getLightLevel(){
		return 15;
	}
	
	public function getName(){
		return "Sea Lantern";
	}

	public function getHardness(){
		return 0.3;
	}

	public function getResistance(){
		return 1.5;
	}

	public function getDrops(Item $item){
		return [
			[Item::PRISMARINE_CRYSTAL, 0, mt_rand(2, 3)],
		];
	}
}