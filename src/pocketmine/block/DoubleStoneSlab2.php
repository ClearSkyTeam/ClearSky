<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class DoubleStoneSlab2 extends Solid{

	protected $id = self::DOUBLE_STONE_SLAB2;

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
		static $names = [
			0 => "Red Sandstone",
			1 => "?",
			2 => "?",
			3 => "?",
			4 => "?",
			5 => "?",
			6 => "?",
			7 => "?",
		];
		return "Double " . $names[$this->meta & 0x07] . " Slab";
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[Item::STONE_SLAB2, $this->meta & 0x07, 2],
			];
		}else{
			return [];
		}
	}

}