<?php
namespace pocketmine\event\block;

use pocketmine\block\Block;
use pocketmine\event\Cancellable;

class LeavesDecayEvent extends BlockEvent implements Cancellable{
	public static $handlerList = null;

	public function __construct(Block $block){
		parent::__construct($block);
	}

}