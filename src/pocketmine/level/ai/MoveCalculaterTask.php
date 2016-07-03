<?php

namespace pocketmine\level\ai;

use pocketmine\Server;
use pocketmine\level\Level;
use pocketmine\scheduler\AsyncTask;
use pocketmine\entity\ai\AIManager;

class MoveCalculaterTask extends AsyncTask{
	#private $server;
	private $level;
	private $levelId;
	private $entityId;
	private $entityType;

	private $result = null;
	private $serialized = false;
	private $cancelRun = false;
	/** @var int */
	private $taskId = null;

	public function __construct(Level $level, $levelId, $entityId, $entityType){
		$this->level = $level;
		$this->levelId = $levelId;
		#$this->server = $level->getServer();
		$this->entityId = $entityId;
		$this->entityType = $entityType;
		print("construct succeed\n");
	}

	public function onRun(){
		/*#$rs = "LevelId: ".$this->levelId." EntityId: ".$this->entityId." EntityType: ".$this->entityType;
		#$entity = $this->level->getEntity($this->entityId);
		#print_r($entity);
		// AIManager::calculateMovement($entity);
		#$x = $entity->x + 1;
		#$y = $entity->y + 1;
		#$z = $entity->z + 1;
		$x = 0;
		$y = 0;
		$z = 0;
		$id = $this->entityId;
		$rs = ['id' => $id, 'x' => $x, 'y' => $y, 'z' => $z];
		#$this->setResult($rs, false);
		print_r($rs);*/
		print("Calculating\n");
		$this->setResult(array('test' => 'bla'), false);
	}

	public function onCompletion(Server $server){
		/*
		 * $ai = $this->level->getAI();
		 * if($ai instanceof AI and $this->hasResult()){
		 * $ai->moveCalculationCallback($this->getResult());
		 * }
		 */
		if($this->hasResult()){
			$this->level->getServer()->broadcastMessage($this->getResult()['test'] . "\n");
			#$entity = $this->level->getEntity($this->entityId);
			#if($entity->onUpdate($currentTick)) $entity->scheduleUpdate();
		}
		else{
			print($this->hasResult() . "\n");
		}
	}
}