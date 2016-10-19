<?php

namespace pocketmine\entity\ai;

use pocketmine\Server;
use pocketmine\entity\Entity;

class AIManager{
	public $knownAIs = [];
	public $server = null;

	public function __construct(Server $server){
		$this->server = $server;
	}

	private function startAI($classname){
		foreach($this->server->getLevels() as $level){
			foreach($level->getEntities() as $entity){
				if($entity instanceof $classname){
					print("Entity of type $classname found!");
					print("Starting AI for $classname\n");
					// $entity->setDataProperty(Entity::DATA_NO_AI, Entity::DATA_TYPE_BYTE, 1);
					$level->getAI()->loadAI($entity);
				}
			}
		}
	}

	public function startAllAIs(){
		foreach($this->knownAIs as $classname){
			$this->startAI($classname);
		}
	}

	private function stopAI($classname){
		foreach($this->server->getLevels() as $level){
			foreach($level->getEntities() as $entity){
				if($entity->getName() === $classname){
					$level->getAI()->unloadAI($entity);
				}
			}
		}
	}

	public function registerAIs($className, $aiclassName){
		$this->knownAIs[$aiclassName] = $className;
		print "Registered " . $aiclassName . " for " . $className . "\n";
		print_r($this->knownAIs);
	}

	public function unregisterAIs($aiclassName){
		unset($this->knownAIs[$aiclassName]);
		print "Unregistered " . $aiclassName . " for " . $className . "\n";
		return true;
	}

	public function isAIRegistered($classname){
		return (in_array($classname, array_flip($this->knownAIs)));
	}

	public function getAI($classname){
		return ($this->isAIRegistered($classname)?array_flip($this->knownAIs)[$classname]:null);
	}

	public function calculateMovement($classname, $json){
		if($this->isAIRegistered($classname)){
			$ai = $this->getAI($entity->getName());
			if(!$ai instanceof BaseAI){
				print "fuck no";
				return $json;
			}
			return $ai->calculateMovement($classname, $json);
		}
		return $json;
	}

	/**
	 *
	 * @return array $knownAIs
	 */
	public function getKnownAIs(){
		return $this->knownAIs;
	}

	/**
	 *
	 * @return Server $server
	 */
	public function getServer(){
		return $this->server;
	}
}