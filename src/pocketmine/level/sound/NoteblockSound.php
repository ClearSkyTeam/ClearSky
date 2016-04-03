<?php
namespace pocketmine\level\sound; 

use pocketmine\level\sound\Sound;
use pocketmine\math\Vector3;
use pocketmine\network\protocol\BlockEventPacket;

class NoteblockSound extends Sound {

	const INSTRUMENT_PIANO = 0;
	const INSTRUMENT_BASEDRUM = 1;
	const INSTRUMENT_SNARE = 2;
	const INSTRUMENT_CLICKS = 3;
	const INSTRUMENT_BASEGUITAR = 4;

	private $instrument = self::INSTRUMENT_PIANO;
	private $pitch = 0;

	public function __construct(Vector3 $pos, $instrument = self::INSTRUMENT_PIANO, $pitch = 0){
		parent::__construct($pos->x, $pos->y, $pos->z);
		$this->instrument = $instrument;
		$this->pitch = $pitch;
	}

	public function encode(){
		$pk = new BlockEventPacket();
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->case1 = $this->instrument;
		$pk->case2 = $this->pitch;
		return $pk;
	}
}