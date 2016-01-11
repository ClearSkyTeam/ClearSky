<?php
namespace pocketmine\item;

class Bone extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::BONE, $meta, $count, "Bone");
	}

}

