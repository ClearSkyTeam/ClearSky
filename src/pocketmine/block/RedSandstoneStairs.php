<?php
namespace pocketmine\block;

class RedSandstoneStairs extends SandstoneStairs{

	protected $id = self::RED_SANDSTONE_STAIRS;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Red Sandstone Stairs";
	}

}