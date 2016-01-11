<?php
namespace pocketmine\block;


use pocketmine\item\Tool;

class Snow extends Solid{

	protected $id = self::SNOW_BLOCK;

	public function __construct(){

	}

	public function getHardness(){
		return 0.2;
	}

	public function getToolType(){
		return Tool::TYPE_SHOVEL;
	}

	public function getName(){
		return "Snow Block";
	}

}