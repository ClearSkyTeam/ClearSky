<?php

namespace pocketmine\level\ai;

use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;
use pocketmine\entity\ai\AIManager;
use pocketmine\network\protocol\MoveEntityPacket;
use pocketmine\entity\ai\BaseAI;
use pocketmine;
use pocketmine\entity\Entity;

class MoveCalculaterTask extends AsyncTask{
	// private $server;
	private $yaw;
	private $levelId;
	private $entityId;
	private $entityType;
	private $knownAIs;
	private $knownAIjson;
	private $result = null;
	private $serialized = false;
	private $cancelRun = false;
	/** @var int */
	private $taskId = null;

	public function __construct($knownAIs, $levelId, $entityId, $entityType, $json){
		$this->knownAIjson = $knownAIs;
		$this->knownAIs = json_decode($knownAIs, true);
		$this->levelId = $levelId;
		$this->entityId = $entityId;
		$this->entityType = $entityType;
		$this->json = $json;
	}
	
	// From AIManager
	public function calculateMovement($classname, $json){
		$aiclass = '\\pocketmine\\entity\\ai\\'.$this->entityType . 'AI';
		$ai = new $aiclass();
		#$ai = $this->getAI($classname);
		if(!$ai instanceof BaseAI){
			print "fuck no";
			return $json;
		}
		return $ai->calculateMovement($classname, $json);
		return $json;
	}

	public function getAI($classname){
		return ($this->isAIRegistered($classname)?array_flip(json_decode($this->knownAIjson, true))[$classname]:null);
		return ($this->isAIRegistered($classname)?array_flip($this->knownAIs)[$classname]:null);
	}

	public function isAIRegistered($classname){
		return (in_array($classname, array_flip(json_decode($this->knownAIjson, true))));
		return (in_array($classname, array_flip($this->knownAIs)));
	}

	public function onRun(){
		// $rs = ["LevelId" => $this->levelId, "EntityId" => $this->entityId, "EntityType" => $this->entityType, "yaw" => $this->yaw];
		// if(is_null(Server::getInstance()::getAIManager())){
		// $this->cancelRun();
		// return;
		// }
		if(empty($this->knownAIs)){
			$this->cancelRun();
			return;
		}
		$data = json_decode($this->calculateMovement($this->entityType, $this->json), true);
		// $rs = ['id' => $id, 'x' => $x, 'y' => $y, 'z' => $z];
		$rs = ["LevelId" => $this->levelId, "EntityId" => $this->entityId, "EntityType" => $this->entityType, 'data' => $data];
		$this->setResult($rs);
	}

	public function onCompletion(Server $server){
		$level = $server->getLevel($this->getResult()["LevelId"]);
		$entity = $level->getEntity($this->getResult()["EntityId"]);
		if($entity != null){
			// AIManager::calculateMovement($entity);
			$server->broadcastTip(var_export($this->getResult(), true));
			$entity->x = $this->getResult()['data']["x"];
			$entity->y = $this->getResult()['data']["y"];
			$entity->z = $this->getResult()['data']["z"];
			$entity->yaw = $this->getResult()['data']["yaw"];
			$entity->pitch = $this->getResult()['data']["pitch"];
			// $entity->move($entity->motionX, $entity->motionY, $entity->motionZ);
			$entity->getLevel()->addEntityMovement($entity->chunk->getX(), $entity->chunk->getZ(), $entity->getId(), $entity->x, $entity->y, $entity->z, $entity->yaw, $entity->pitch);
		}
	}
}