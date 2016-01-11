<?php
namespace pocketmine\item;


class Saddle extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::SADDLE, 0, $count, "Saddle");
	}

	public function getMaxStackSize(){
		return 1;
	}

}