<?php
namespace pocketmine\block;


use pocketmine\item\Tool;

class Wool extends Solid{

	protected $id = self::WOOL;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness(){
		return 0.8;
	}

	public function getToolType(){
		return Tool::TYPE_SHEARS;
	}

	public function getName(){
		static $names = [
			0 => "White Wool",
			1 => "Orange Wool",
			2 => "Magenta Wool",
			3 => "Light Blue Wool",
			4 => "Yellow Wool",
			5 => "Lime Wool",
			6 => "Pink Wool",
			7 => "Gray Wool",
			8 => "Light Gray Wool",
			9 => "Cyan Wool",
			10 => "Purple Wool",
			11 => "Blue Wool",
			12 => "Brown Wool",
			13 => "Green Wool",
			14 => "Red Wool",
			15 => "Black Wool",
		];
		return $names[$this->meta & 0x0f];
	}

}