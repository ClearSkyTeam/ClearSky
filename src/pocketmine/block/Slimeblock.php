<?php

namespace pocketmine\block;

use pocketmine\event\entity\EntityDamageEvent;

class Slimeblock extends Transparent{
	protected $id = self::SLIMEBLOCK;

	public function __construct(){}

	public function getName(){
		return "Slime Block";
	}

	public function getHardness(){
		return 0;
	}

	public function damageHandler(EntityDamageEvent $event){
		$cause = $event->getCause();
		$entity = $event->getEntity();
		if($cause == EntityDamageEvent::CAUSE_FALL && $entity->getLevel()->getBlock($entity->getSide(0))->getId() === $this->getId()){
			if(!$entity->isSneaking()) $event->setCancelled(true);
			if(!$entity->isSneaking() && !$entity->getMotion()->distanceSquared($entity->getPosition()->subtract(0, 1)->floor()) > 0.1){
				$entity->setMotion($entity->getMotion()->add(0, (($entity->getMotion()->getY() * 2) * 0.88), 0));
			}
		}
	}
}