<?php
namespace pocketmine\item;

class Apple extends Food{
	public $saturation = 4;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::APPLE, 0, $count, "Apple");
	}
}