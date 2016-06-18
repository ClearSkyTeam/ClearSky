<?php
namespace pocketmine\network;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class CompressBatchedTask extends AsyncTask{

	public $level = 7;
	public $data;
	public $final;
	public $targets = [];

	public function __construct($data, array $targets, $level = 7){
		$this->data = $data;
		$this->targets = $targets;
		$this->level = $level;
	}

	public function onRun(){
		try{
			$this->final = zlib_encode($this->data, ZLIB_ENCODING_DEFLATE, $this->level);
			$this->data = null;
		}catch(\Exception $e){

		}
	}

	public function onCompletion(Server $server){
		$server->broadcastPacketsCallback($this->final, $this->targets);
	}
}
