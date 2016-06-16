<?php
namespace pocketmine\scheduler;

class FileWriteTask extends AsyncTask{

	private $path;
	private $contents;
	private $flags;

	public function __construct($path, $contents, $flags = 0){
		$this->path = $path;
		$this->contents = $contents;
		$this->flags = (int) $flags;
	}

	public function onRun(){
		try{
			file_put_contents($this->path, $this->contents, (int) $this->flags);
		}catch (\Throwable $e){

		}
	}
}
