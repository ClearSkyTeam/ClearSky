<?php
namespace pocketmine\level\sound;

use pocketmine\math\Vector3;
use pocketmine\network\protocol\LevelSoundEventPacket;

class GenericSound extends Sound{
	
	public function __construct(Vector3 $pos, $id, $pitch = 0){
		if(LevelSoundEventPacket::getSound($id) === false){print "fail"; return;}
		parent::__construct($pos->x, $pos->y, $pos->z);
		$this->id = $id;
		$this->pitch = (float) $pitch * 1000;
		$this->volume = (int) 100;
		$this->unknownBool = (bool) true;
		$this->unknownBool2 = (bool) true;
	}
	
	protected $id;
	protected $pitch = 0;
	protected $volume = 100;
	protected $unknownBool = true;
	protected $unknownBool2 = true;
	
	public function getPitch(){
		return $this->pitch / 1000;
	}
	
	public function setPitch($pitch){
		$this->pitch = (float) $pitch * 1000;
	}
	
	
	public function encode(){
		$pk = new LevelSoundEventPacket();
		$pk->sound = $this->id;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->volume = $this->volume;
		$pk->pitch = $this->pitch;
		$pk->unknownBool = $this->unknownBool;
		$pk->unknownBool2 = $this->unknownBool2;
		
		return $pk;
	}

}
