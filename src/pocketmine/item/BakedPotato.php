<?php
namespace pocketmine\item;

class BakedPotato extends Food{
	public $saturation = 5;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::BAKED_POTATO, $meta, $count, "Baked Potato");
	}
}