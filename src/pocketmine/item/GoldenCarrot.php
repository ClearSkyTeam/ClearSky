<?php
namespace pocketmine\item;

class GoldenCarrot extends Food{
	public $saturation = 6;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GOLDEN_CARROT, 0, $count, "Golden Carrot");
	}
}