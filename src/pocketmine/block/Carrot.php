<?php
namespace pocketmine\block;

use pocketmine\item\Item;

class Carrot extends Crops{

	protected $id = self::CARROT_BLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Carrot Block";
	}

	public function getDrops(Item $item){
		$drops = [];
		if($this->meta >= 0x07){
			$drops[] = [Item::CARROT, 0, mt_rand(1, 4)];
		}else{
			$drops[] = [Item::CARROT, 0, 1];
		}

		return $drops;
	}
}