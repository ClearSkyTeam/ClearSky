<?php
namespace pocketmine\block;

use pocketmine\item\Item;

class Prismarine extends Solid{

	protected $id = Item::PRISMARINE;

	public function __construct(){}

	public function getName(){
		return "Prismarine";
	}

}