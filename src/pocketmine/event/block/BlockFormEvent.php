<?php
namespace pocketmine\event\block;

use pocketmine\block\Block;
use pocketmine\event\Cancellable;

class BlockFormEvent extends BlockGrowEvent implements Cancellable{
	public static $handlerList = null;

	public function __construct(Block $block, Block $newState){
		parent::__construct($block, $newState);
	}

}