<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class Sandstone extends Solid{

	const NORMAL = 0;
	const CHISELED = 1;
	const SMOOTH = 2;

	protected $id = self::SANDSTONE;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness(){
		return 0.8;
	}

	public function getName(){
		static $names = [
			self::NORMAL => "Sandstone",
			self::CHISELED => "Chiseled Sandstone",
			self::SMOOTH => "Smooth Sandstone",
			3 => "",
		];
		return $names[$this->meta & 0x03];
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[Item::SANDSTONE, $this->meta & 0x03, 1],
			];
		}else{
			return [];
		}
	}

}