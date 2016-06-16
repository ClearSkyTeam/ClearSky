<?php
namespace pocketmine\item;


class BeetrootSoup extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::BEETROOT_SOUP, 0, $count, "Beetroot Soup");
	}

	public function getMaxStackSize(){
		return 1;
	}

	public function getFoodRestore(){
		return 6;
	}

	public function getSaturationRestore(){
		return 7.2;
	}

	public function getResidue(){
		return Item::get(Item::BOWL);
	}
}