<?php

namespace pocketmine\level\ai;

use pocketmine\level\Level;
use pocketmine\entity\Entity;
use pocketmine\network\protocol\MoveEntityPacket;
use pocketmine\network\protocol\SetEntityMotionPacket;

class AI{
	private $level;
	private $levelId;
	private $mobs = [];

	public function __construct(Level $level){
		$this->level = $level;
		$this->levelId = $level->getId();
	}

	public function getLevel(){
		return $this->level;
	}

	public function getServer(){
		return $this->level->getServer();
	}

	public function registerAI(Entity $entity){
		$this->mobs[$entity->getId()] = $entity->getName();
		$this->getServer()->broadcastMessage("AI ticking for ".$entity->getName().": ".$entity->getId());
	}

	public function unregisterAI(Entity $entity){
		unset($this->mobs[$entity->getId()]);
	}

	public function tickMobs(){
		foreach($this->mobs as $mobId => $mobType){
			$this->getServer()->getScheduler()->scheduleAsyncTask(new MoveCalculaterTask($this->getLevel(), $this->levelId, $mobId, $mobType));
		}
	}

	public function moveCalculationCallback($result){
		$entity = $this->getServer()->getLevel($this->levelId)->getEntity($result['id']);
		$pos = $entity->temporalVector->setComponents($result['x'], $result['y'], $result['z']);
		$this->getServer()->broadcastMessage($pos->__toString());
	}
}