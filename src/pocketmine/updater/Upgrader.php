<?php
namespace pocketmine\updater;

use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;

class Upgrader extends AsyncTask{
	private $dlink;
	private $dfile;
	
	public function __construct($link){
		$this->dlink = $link;
	}
	
	public function onRun(){
		//file_put_contents($this->dfile,file_get_contents($this->dlink));
	}
	
	public function onCompletion(Server $server){
		$updater = $server->getUpdater();
		$updater->downloadCompleteCallback();
	}
}