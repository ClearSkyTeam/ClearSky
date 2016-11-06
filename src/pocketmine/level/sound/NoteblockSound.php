<?php
namespace pocketmine\level\sound; 

use pocketmine\level\sound\Sound;
use pocketmine\math\Vector3;
use pocketmine\network\protocol\BlockEventPacket;

class NoteblockSound extends Sound {

	const INSTRUMENT_PIANO = 'note.harp';
	const INSTRUMENT_BASEDRUM = 'note.bd';
	const INSTRUMENT_SNARE = 'note.snare';
	const INSTRUMENT_CLICKS = 'note.hat'; // TODO: Check these
	const INSTRUMENT_BASEGUITAR = 'note.bass';

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