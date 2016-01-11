<?php
namespace pocketmine\item;

class Bread extends Food{
	public $saturation = 5;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::BREAD, $meta, $count, "Bread");
	}
}