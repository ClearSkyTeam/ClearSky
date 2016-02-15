<?php
namespace pocketmine\item;

class EnderPearl extends Launchable{
	protected $entityname = "EnderPearl";
	protected $f = 1.5;
	
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::ENDERPEARL, 0, $count, "Ender Pearl");
	}

	public function getMaxStackSize(){
		return 16;
	}

}