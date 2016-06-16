<?php
namespace pocketmine\item;

class Beetroot extends Food{
	public $saturation = 1;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::BEETROOT, $meta, $count, "Beetroot");
	}
}