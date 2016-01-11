<?php
namespace pocketmine\block;


use pocketmine\item\Tool;

class Bookshelf extends Solid{

	protected $id = self::BOOKSHELF;

	public function __construct(){

	}

	public function getName(){
		return "Bookshelf";
	}

	public function getHardness(){
		return 1.5;
	}

	public function getToolType(){
		return Tool::TYPE_AXE;
	}

}