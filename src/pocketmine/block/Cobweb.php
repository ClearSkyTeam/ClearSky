<?php

namespace pocketmine\block;

use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\item\Tool;

class Cobweb extends Flowable{
	protected $id = self::COBWEB;

	public function __construct(){}

	public function hasEntityCollision(){
		return true;
	}

	public function getName(){
		return "Cobweb";
	}

	public function getHardness(){
		return 4;
	}

	public function getToolType(){
		return Tool::TYPE_SWORD;
	}

	public function onEntityCollide(Entity $entity){
		$entity->resetFallDistance();
	}

	public function getDrops(Item $item){
		$drops = [];
		if($item->isSword()){
			$drops[] = [Item::get($this->id, 0, 1)];
		}
		return $drops;
	}
}