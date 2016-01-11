<?php
namespace pocketmine\scheduler;

class GarbageCollectionTask extends AsyncTask{

	public function onRun(){
		gc_enable();
		gc_collect_cycles();
	}
}
