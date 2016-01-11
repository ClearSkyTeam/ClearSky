<?php
namespace pocketmine\item;

class RawPorkchop extends Food{
	public $saturation = 3;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::RAW_PORKCHOP, $meta, $count, "Raw Porkchop");
	}
}