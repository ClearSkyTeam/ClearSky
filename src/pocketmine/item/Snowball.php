<?php
namespace pocketmine\item;

class Snowball extends Launchable{
	protected $entityname = "Snowball";
	protected $f = 1.5;
	
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::SNOWBALL, 0, $count, "Snowball");
	}

	public function getMaxStackSize(){
		return 16;
	}

}