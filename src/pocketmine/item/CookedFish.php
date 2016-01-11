<?php
namespace pocketmine\item;

class CookedFish extends Food{
	const NORMAL = 0;
	const SALMON = 1;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::COOKED_FISH);
		$this->meta = $meta;
		$this->name = $this->getMetaName();
	}

	public function getMetaName(){
		static $names = [self::NORMAL => "Cooked Fish",self::SALMON => "Cooked Salmon",2 => "Unknown Cooked Fish"];
		return $names[$this->meta & 0x02];
	}

	public function getSaturation(){
		return ($this->meta === self::NORMAL)?5:(($this->meta === self::SALMON)?6:0);
	}
}