<?php
namespace pocketmine\item;

class RabbitStew extends Food{
	public $saturation = 10;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::RABBIT_STEW, 0, $count, "Rabbit Stew");
	}
}