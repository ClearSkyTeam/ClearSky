<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\level\Level;

class Ice extends Transparent{
	protected $id = self::ICE;
	public function __construct(){
	}
	public function getName(){
		return "Ice";
	}
	public function getHardness(){
		return 0.5;
	}
	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}
	public function onBreak(Item $item){
		$this->getLevel()->setBlock($this, new Water(), true);
		return true;
	}
	public function getDrops(Item $item){
		return [];
	}
	
	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_RANDOM){
			if($this->getLevel()->getBlockLightAt($this->x, $this->y, $this->z) >= 12){
				$this->getLevel()->setBlock($this, new Water(), true);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
}