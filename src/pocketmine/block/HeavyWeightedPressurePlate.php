<?php

namespace pocketmine\block;

use pocketmine\item\Tool;
use pocketmine\item\Item;

class HeavyWeightedPressurePlate extends WoodenPressurePlate{
	protected $id = self::HEAVY_WEIGHTED_PRESSURE_PLATE;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName(){
		return "Heavy Weighted Pressure Plate";
	}

	public function getHardness(){
		return 0.5;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe()){
			return [$this->id,0,1];
		}
		return [];
	}

	public function isEntityCollided(){
		$entities = 0;
		foreach($this->getLevel()->getChunk($this->x >> 4, $this->z >> 4)->getEntities() as $entity){
			$pos = $entity->getPosition();
			if(abs($this->x - $pos->x) < 1.5 and abs($this->y - $pos->y) < 1.5 and abs($this->z - $pos->z) < 1.5){
				$entities++;
			}
		}
		if($this->getPower() !== floor($entities / 10) + 1){
			$this->setPower(floor($entities / 10) + 1);
			return true;
		}
		return $entities !== 0;
	}
}
