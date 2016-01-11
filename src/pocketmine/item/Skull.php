<?php
namespace pocketmine\item;


use pocketmine\block\Block;
class Skull extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Block::SKULL_BLOCK);
		parent::__construct(self::SKULL, $meta, $count, "Skull");
	}

	public function getMaxStackSize(){
		return 64;
	}

}
