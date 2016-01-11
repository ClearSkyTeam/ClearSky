<?php
namespace pocketmine\block;


use pocketmine\item\Tool;

class NetherBrickStairs extends Stair{

	protected $id = self::NETHER_BRICKS_STAIRS;

	public function getName(){
		return "Nether Bricks Stairs";
	}

	public function getHardness(){
		return 2;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

}