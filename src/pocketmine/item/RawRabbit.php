<?php
namespace pocketmine\item;

class RawRabbit extends Food{
	public $saturation = 3;
	public $smeltingExp = 0.35;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::RAW_RABBIT, $meta, $count, "Raw Rabbit");
	}
}