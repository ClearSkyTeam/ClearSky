<?php

namespace pocketmine\entity\ai;

use pocketmine\Server;
use pocketmine\entity\Entity;

abstract class AIManager{
	private static $knownAIs = [];
	private static $server = null;

	public function __construct(){}

	private static function startAI($classname, Server $server){
		print("Starting AI for $classname\n");
		foreach($server->getLevels() as $level){
			foreach($level->getEntities() as $entity){
				if($entity instanceof $classname){
					print("Entity of type $classname found!");
					$entity->setDataProperty(Entity::DATA_NO_AI, Entity::DATA_TYPE_BYTE, 1);
					$level->getAI()->registerAI($entity);
				}
			}
		}
	}

	public static function startAllAIs(Server $server){
		foreach(self::$knownAIs as $classname){
			self::startAI($classname, $server);
		}
	}

	private static function stopAI($classname, Server $server){
		foreach($server->getLevels() as $level){
			foreach($level->getEntities() as $entity){
				if($entity->getName() === $classname){
					$level->getAI()->unregisterAI($entity);
				}
			}
		}
	}

	public static function registerAIs($className, $aiclassName, Server $server){
		self::$knownAIs[$aiclassName] = $className;
	}

	public static function unregisterAIs($aiclassName){
		unset(self::$knownAIs[$aiclassName]);
		return true;
	}

	public function isAIRegistered($classname){
		return (in_array($classname, array_flip(self::$knownAIs)));
	}

	public function getAI($classname){
		return (self::isAIRegistered($classname)?array_flip(self::$knownAIs)[$classname]:null);
	}

	public static function calculateMovement(Entity $entity){
		$ai = self::getAI($entity->getName());
		return $ai->calculateMovement();
	}
}