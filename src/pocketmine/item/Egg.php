<?php
namespace pocketmine\item;

class Egg extends Launchable{
	protected $entityname = "Egg";
	
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::EGG, $meta, $count, "Egg");
	}

}

