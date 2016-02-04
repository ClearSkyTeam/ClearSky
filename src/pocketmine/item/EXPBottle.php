<?php
namespace pocketmine\item;

class EXPBottle extends Launchable{
	protected $entityname = "ThrownExpBottle";
	protected $f = 1.1;
	
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::EXP_BOTTLE, $meta, $count, "Bottle o' Enchanting");
	}

}

