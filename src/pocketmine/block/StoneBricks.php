<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class StoneBricks extends Solid{
	const NORMAL = 0;
	const MOSSY = 1;
	const CRACKED = 2;
	const CHISELED = 3;

	protected $id = self::STONE_BRICKS;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness(){
		return 1.5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName(){
		static $names = [
			self::NORMAL => "Stone Bricks",
			self::MOSSY => "Mossy Stone Bricks",
			self::CRACKED => "Cracked Stone Bricks",
			self::CHISELED => "Chiseled Stone Bricks",
		];
		return $names[$this->meta & 0x03];
	}
	
	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[Item::STONE_BRICKS, $this->meta & 0x03, 1],
			];
		}else{
			return [];
		}
	}

}