<?php

namespace pocketmine\level\sound;

use pocketmine\block\Block;

class BlockBreakSound extends GenericSound{
	protected $data;

	public function __construct(Block $b){
		$this->data = $b->getId();
		parent::__construct($b, 'break', $this->data, $pitch = 0);
	}
}