<?php
namespace pocketmine\updater;

use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;

class Upgrader extends AsyncTask{
	private $dlink;
	private $dfile;
	private $md5hash;
	private $status = true;
	
	public function __construct($link,$hash){
		$this->md5hash = $hash;
		$this->dlink = $link;
		$this->dfile = str_replace("phar://","",dirname(dirname(dirname(dirname(__FILE__)))));
	}
	
	public function onRun(){
		if(!(\Phar::running(true) === "")){
			$file_name = $this->dfile;
			$downloaded_file = file_get_contents($this->dlink);
			if($downloaded_file){
				if(md5($downloaded_file) == $this->md5hash){
					rename($file_name,$file_name.time().'.bak');
					file_put_contents($file_name,$downloaded_file);
				}else{
					$this->status = false;
				}
			}else{
				$this->status = false;
			}
		}else{
			$this->status = false;
		}
	}
	
	public function onCompletion(Server $server){
		$updater = $server->getUpdater();
		if($this->status){
			$updater->downloadCompleteCallback();
		}else{
			$updater->downloadFailCallback();
		}
	}
}