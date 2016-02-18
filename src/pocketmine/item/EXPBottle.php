<?php
namespace pocketmine\item;

class EXPBottle extends Item implements Launchable{
	protected $entityname = "ThrownExpBottle";
	protected $f = 1.1;
	
	public function isLaunchable(){
		return true;
	}
	
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::EXP_BOTTLE, $meta, $count, "Bottle o' Enchanting");
	}

}

