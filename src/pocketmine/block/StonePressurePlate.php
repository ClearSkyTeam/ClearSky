<?php
namespace pocketmine\block;

use pocketmine\item\Tool;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\item\Item;

class StonePressurePlate extends WoodenPressurePlate{

	protected $id = self::STONE_PRESSURE_PLATE;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}
	
	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName(){
		return "Stone Pressure Plate";
	}

	public function getHardness(){
		return 0.5;
	}
	
	public function isCollidedType(Entity $entity){
		if($entity instanceof Living){
			return true;
		}
		return false;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe()){
			return [$this->id, 0, 1];
		}
		return [];
	}
}