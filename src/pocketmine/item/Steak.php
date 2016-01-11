<?php
namespace pocketmine\item;

class Steak extends Food{
	public $saturation = 8;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::STEAK, $meta, $count, "Steak");
	}
}