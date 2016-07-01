<?php

namespace pocketmine\item;

use pocketmine\entity\Entity;
use pocketmine\entity\Sheep;
use pocketmine\entity\Mooshroom;
class Shears extends Tool{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::SHEARS, $meta, $count, "Shears");
	}

	public function getMaxDurability(){
		return 238;
	}
	
	public function useOnEntity(Entity $entity, Entity $origin){
		if($entity instanceof Sheep || $entity instanceof Mooshroom)
			$entity->sheer();
	}
}