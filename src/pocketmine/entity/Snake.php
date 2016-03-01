<?php

namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\network\protocol\EntityEventPacket;
use pocketmine\Server;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\network\protocol\AnimatePacket;
use pocketmine\Player;

class Snake extends Entity{
	// Have fun guessing why
	protected $attackTime = 0;

	public function attack($damage, EntityDamageEvent $source){
		if($this->attackTime > 0 or $this->noDamageTicks > 0){
			$lastCause = $this->getLastDamageCause();
			if($lastCause !== null and $lastCause->getDamage() >= $damage){
				$source->setCancelled();
			}
		}
		
		parent::attack($damage, $source);
		
		if($source->isCancelled()){
			return;
		}
		
		if($source instanceof EntityDamageByEntityEvent){
			$e = $source->getDamager();
			if($source instanceof EntityDamageByChildEntityEvent){
				$e = $source->getChild();
			}
			
			if($e->isOnFire() > 0){
				$this->setOnFire(2 * $this->server->getDifficulty());
			}
		}
		$pk = new EntityEventPacket();
		$pk->eid = $this->getId();
		$pk->event = $this->getHealth() <= 0?EntityEventPacket::DEATH_ANIMATION:EntityEventPacket::HURT_ANIMATION; // Ouch!
		Server::broadcastPacket($this->hasSpawned, $pk);
		// TESTING
		for($i = 0; $i < 400; $i++){
			$pk = new AnimatePacket();
			$pk->eid = $this->getId();
			$pk->action = $i;
			Server::broadcastPacket($this->hasSpawned, $pk);
		}
		// END TESTING
		
		$this->attackTime = 0; // 0.5 seconds cooldown
	}

	public function kill(){
		if(!$this->isAlive()){
			return;
		}
		parent::kill();
		foreach($this->getDrops() as $item){
			$this->getLevel()->dropItem($this, $item);
		}
		if(!$this->closed){
			$this->close();
		}
	}

	public function getDrops(){
		return [];
	}
}