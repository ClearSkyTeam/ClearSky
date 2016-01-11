<?php
namespace pocketmine\block;


class NetherReactor extends Solid{

	protected $id = self::NETHER_REACTOR;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Nether Reactor";
	}

	public function canBeActivated(){
		return true;
	}

}