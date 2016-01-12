<?php
namespace pocketmine\block;


use pocketmine\item\Tool;

class Sand extends Fallable{

	protected $id = self::SAND;
	public $exp_smelt = 0.1;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness(){
		return 0.5;
	}

	public function getToolType(){
		return Tool::TYPE_SHOVEL;
	}

	public function getName(){
		if($this->meta === 0x01){
			return "Red Sand";
		}

		return "Sand";
	}

}