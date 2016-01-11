<?php
namespace pocketmine\item;

class Melon extends Food{
	public $saturation = 2;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::MELON, $meta, $count, "Melon");
	}
}