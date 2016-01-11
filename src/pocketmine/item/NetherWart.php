<?php
namespace pocketmine\item;

use pocketmine\block\Block;

class NetherWart extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::NETHER_WART, $meta, $count, "Nether Wart");
	}

}

