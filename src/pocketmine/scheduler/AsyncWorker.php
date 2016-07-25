<?php
namespace pocketmine\scheduler;

use pocketmine\Worker;

class AsyncWorker extends Worker{

	private $logger;
	private $id;

	public function __construct(\ThreadedLogger $logger, $id){
		$this->logger = $logger;
		$this->id = $id;
	}

	public function run(){
		$this->registerClassLoader();
		gc_enable();
		ini_set("memory_limit", -1);

		global $store;
		$store = [];

	}

	public function handleException(\Throwable $e){
		$this->logger->logException($e);
	}

	public function getThreadName(){
		return "Asynchronous Worker #" . $this->id;
	}
}
