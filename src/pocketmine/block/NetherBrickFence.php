<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class NetherBrickFence extends Fence{

	protected $id = self::NETHER_BRICK_FENCE;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness(){
		return 2;
	}
        
	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}
	
	public function getName(){
		return "Nether Brick Fence";
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[$this->id, $this->meta, 1],
			];
		}else{
			return [];
		}
	}        
}
