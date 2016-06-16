<?php
namespace pocketmine\item;

class CookedChicken extends Food{
	public $saturation = 6;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::COOKED_CHICKEN, $meta, $count, "Cooked Chicken");
	}
}