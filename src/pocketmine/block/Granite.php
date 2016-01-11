<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class Granite extends Solid{

	protected $id = 1;

	public function __construct($meta = 1){
		$this->meta = $meta;
	}

	public function getHardness(){
		return 1.5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName(){
		return "Granite";
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[$this->getDamage() === 0 ? Item::COBBLESTONE : Item::STONE, $this->getDamage(), 1],
			];
		}else{
			return [];
		}
	}

}