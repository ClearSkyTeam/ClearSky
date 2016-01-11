<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\level\Level;

class RedstoneOre extends Solid{

	protected $id = self::REDSTONE_ORE;
	protected $exp_min = 1;
	protected $exp_max = 5;
	public $smeltingExp = 0.7;

	public function __construct(){

	}

	public function getName(){
		return "Redstone Ore";
	}

	public function getHardness(){
		return 3;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL or $type === Level::BLOCK_UPDATE_TOUCH){
			$this->getLevel()->setBlock($this, Block::get(Item::GLOWING_REDSTONE_ORE, $this->meta), false, true);

			return Level::BLOCK_UPDATE_WEAK;
		}

		return false;
	}



	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_GOLD){
			return [
				[Item::REDSTONE_DUST, 0, mt_rand(4, 5)],
			];
		}else{
			return [];
		}
	}
}