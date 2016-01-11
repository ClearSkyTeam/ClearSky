<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class MonsterSpawner extends Solid{

	protected $exp_min = 15;
	protected $exp_max = 43;

	protected $id = self::MONSTER_SPAWNER;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness(){
		return 5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName(){
		return "Monster Spawner";
	}

	public function getDrops(Item $item){
		return [];
	}
}