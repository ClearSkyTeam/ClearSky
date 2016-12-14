<?php

namespace pocketmine\level\sound;

use pocketmine\math\Vector3;

class NoteblockSound extends GenericSound{
	const INSTRUMENT_PIANO = 0;
	const INSTRUMENT_BASEDRUM = 1;
	const INSTRUMENT_SNARE = 2;
	const INSTRUMENT_CLICKS = 3;
	const INSTRUMENT_BASEGUITAR = 4;
	private $instrument = self::INSTRUMENT_PIANO;

	public function __construct(Vector3 $pos, $instrument = self::INSTRUMENT_PIANO, $pitch = 0){
		parent::__construct($pos, 64, $pitch);
		$this->instrument = $instrument;
		$this->pitch = $pitch;
		$this->type = $this->instrument;
		$this->unknownBool = true;
		$this->unknownBool2 = true;
	}
}