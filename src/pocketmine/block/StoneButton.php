<?php
namespace pocketmine\block;

use pocketmine\item\Tool;
class StoneButton extends WoodenButton{
	protected $id = self::STONE_BUTTON;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Stone Button";
	}
	
	public function getToolType() {
		return Tool::TYPE_PICKAXE;
	}
}
