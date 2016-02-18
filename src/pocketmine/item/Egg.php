<?php
namespace pocketmine\item;

class Egg extends Item implements Launchable{
	protected $entityname = "Egg";
	protected $f = 1.5;
	
	public function isLaunchable(){
		return true;
	}
	
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::EGG, $meta, $count, "Egg");
	}

}

