<?php
/**
 * Block related events
 */
namespace pocketmine\event\block;

use pocketmine\block\Block;
use pocketmine\event\Event;

abstract class BlockEvent extends Event{
	/** @var \pocketmine\block\Block */
	protected $block;

	/**
	 * @param Block $block
	 */
	public function __construct(Block $block){
		$this->block = $block;
	}

	/**
	 * @return Block
	 */
	public function getBlock(){
		return $this->block;
	}
}