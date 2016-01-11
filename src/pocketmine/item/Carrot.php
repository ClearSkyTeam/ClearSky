<?php
namespace pocketmine\item;

use pocketmine\block\Block;

class Carrot extends Food{
	public $saturation = 3;

	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(self::CARROT_BLOCK);
		parent::__construct(self::CARROT, 0, $count, "Carrot");
	}
}