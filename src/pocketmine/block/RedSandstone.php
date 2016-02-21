<?php
namespace pocketmine\block;

class RedSandstone extends Sandstone{

	const NORMAL = 0;
	const CHISELED = 1;
	const SMOOTH = 2;

	protected $id = self::RED_SANDSTONE;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		static $names = [
			self::NORMAL => "Red Sandstone",
			self::CHISELED => "Red Chiseled Sandstone",
			self::SMOOTH => "Red Smooth Sandstone",
			3 => "",
		];
		return $names[$this->meta & 0x03];
	}
}