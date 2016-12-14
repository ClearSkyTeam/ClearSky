<?php
namespace pocketmine\block;

use pocketmine\item\Item;

class Prismarine extends Solid{

	protected $id = Item::PRISMARINE;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Prismarine";
	}

}