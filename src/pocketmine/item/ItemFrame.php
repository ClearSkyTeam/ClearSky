<?php

namespace pocketmine\item;

class ItemFrame extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::ITEM_FRAME, $meta, $count, "Item Frame");
	}
}

