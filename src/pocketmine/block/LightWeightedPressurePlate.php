<?php
namespace pocketmine\block;

use pocketmine\item\Tool;
use pocketmine\item\Item;

class LightWeightedPressurePlate extends WoodenPressurePlate{

	protected $id = self::LIGHT_WEIGHTED_PRESSURE_PLATE;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}
	
	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName(){
		return "Light Weighted Pressure Plate";
	}

	public function getHardness(){
		return 0.5;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe()){
			return [$this->id, 0, 1];
		}
		return [];
	}
}
