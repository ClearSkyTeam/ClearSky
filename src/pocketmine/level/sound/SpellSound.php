<?php
namespace beito\FlowerPot\extra\Cauldron;

use pocketmine\level\sound\Sound;
use pocketmine\math\Vector3;
use pocketmine\network\protocol\LevelEventPacket;

use beito\FlowerPot\MainClass;

class SpellSound extends Sound{

	private $id;
	private $color;

	public function __construct(Vector3 $pos, $r = 0, $g = 0, $b = 0){
		parent::__construct($pos->x, $pos->y, $pos->z);
		$this->id = LevelEventPacket::EVENT_SOUND_SPELL;
		$this->color = ($r << 16 | $g << 8 | $b) & 0xffffff;
	}

	public function encode(){
		$pk = new LevelEventPacket;
		$pk->evid = $this->id;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->data = $this->color;
		
		return $pk;
	}
}