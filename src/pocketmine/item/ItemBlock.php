<?php
namespace pocketmine\item;

use pocketmine\block\Block;

/**
 * Class used for Items that can be Blocks
 */
class ItemBlock extends Item{
	public function __construct(Block $block, $meta = 0, $count = 1){
		$this->block = $block;
		parent::__construct($block->getId(), $block->getDamage(), $count, $block->getName());
	}

	public function setDamage($meta){
		$this->meta = $meta !== null ? $meta & 0xf : null;
		$this->block->setDamage($this->meta);
	}

	public function __clone(){
		$this->block = clone $this->block;
	}

	public function getBlock(){
		return $this->block;
	}

}