<?php
namespace pocketmine\item;

class MagmaCream extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::MAGMA_CREAM, $meta, $count, "Magma Cream");
	}
}