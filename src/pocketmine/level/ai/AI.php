<?php

namespace pocketmine\level\ai;

use pocketmine\level\Level;
use pocketmine\entity\Entity;
use pocketmine\entity\ZombieHorse;
use pocketmine\entity\ai\AIManager;
use pocketmine\entity\Item;
use pocketmine\entity\Human;
use pocketmine\entity\Horse;
use pocketmine\entity\Living;

class AI{
	private $level;
	private $levelId;
	private $mobs = [];
	private $exe = 0;

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

	public function loadAI(Entity $entity){
		if(!$entity instanceof Living || $entity instanceof Human) return;
		// if($entity->getDataProperty(Entity::DATA_NO_AI)){
		// $this->getServer()->broadcastMessage($entity->getName() . ' => NO_AI');
		// return;
		// }
		$this->mobs[$entity->getId()] = $entity->getName();
		$this->getServer()->getLogger()->debug("AI started ticking for " . $entity->getName() . ": " . $entity->getId());
	}

	public function unloadAI(Entity $entity){
		if(isset($this->mobs[$entity->getId()])){
			unset($this->mobs[$entity->getId()]);
			$this->getServer()->getLogger()->debug("AI stopped ticking for " . $entity->getName() . ": " . $entity->getId());
		}
	}

	public function tickMobs(){
		$this->exe++;
		foreach($this->mobs as $mobId => $mobType){
			$levelid = $this->levelId;
			$entity = $this->getLevel()->getEntity($mobId);
			if($entity != null){
				$arr = array('x' => $entity->x, 'y' => $entity->y, 'z' => $entity->z, 'yaw' => $entity->yaw, 'pitch' => $entity->pitch, 'exe' => $this->exe);
				$knownAIs = $this->getServer()::getAIManager()->getKnownAIs();
				$this->getServer()->getScheduler()->scheduleAsyncTask(new MoveCalculaterTask(json_encode($knownAIs), $levelid, $mobId, $mobType, json_encode($arr)));
			}
		}
	}

	public function moveCalculationCallback($result){
		$entity = $this->getServer()->getLevel($this->levelId)->getEntity($result['id']);
		$pos = $entity->temporalVector->setComponents($result[0], $result[1], $result[2]);
		$this->getServer()->broadcastMessage($pos->__toString());
	}
}