<?php
namespace pocketmine\level\sound;

use pocketmine\math\Vector3;
use pocketmine\network\protocol\LevelEventPacket;
use pocketmine\network\protocol\LevelSoundEventPacket;
use pocketmine\Server;

class GenericSound extends Sound{
	
	public function __construct(Vector3 $pos, $id, $pitch = 0){
		if($this->id < 1000 && LevelSoundEventPacket::getSound($id) === false){
			Server::getInstance()->getLogger()->warning("Sound with ID '" . $id . "' wasn't found.");
			return;
		}
		parent::__construct($pos->x, $pos->y, $pos->z);
		$this->id = (int) $id;
		$this->type = 0; //Noteblock type
		$this->pitch = (float) $pitch * 1000;
		$this->unknownBool = (bool) true;
		$this->unknownBool2 = (bool) true;
	}
	
	protected $id;
	protected $type = 0;
	protected $pitch = 0;
	protected $unknownBool = true;
	protected $unknownBool2 = true;
	
	public function getPitch(){
		return $this->pitch / 1000;
	}
	
	public function setPitch($pitch){
		$this->pitch = (float) $pitch * 1000;
	}
	
	
	public function encode(){
		if($this->id > 1000){
			$pk = new LevelEventPacket;
			$pk->evid = $this->id;
			$pk->x = $this->x;
			$pk->y = $this->y;
			$pk->z = $this->z;
			$pk->data = (int) $this->pitch;
		}
		else{
			$pk = new LevelSoundEventPacket();
			$pk->sound = $this->id;
			$pk->x = $this->x;
			$pk->y = $this->y;
			$pk->z = $this->z;
			$pk->type = $this->type;
			$pk->pitch = $this->pitch;
			$pk->unknownBool = $this->unknownBool;
			$pk->unknownBool2 = $this->unknownBool2;
		}
		return $pk;
	}

}
