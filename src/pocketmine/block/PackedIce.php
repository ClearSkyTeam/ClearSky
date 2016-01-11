<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class PackedIce extends Transparent{

	protected $id = self::PACKED_ICE;

	public function __construct(){

	}

	public function getName(){
		return "Packed Ice";
	}

	public function getHardness(){
		return 0.5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getDrops(Item $item){
		return [];
	}
}