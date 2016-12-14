<?php
namespace pocketmine\item;

class PrismarineCrystal extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::PRISMARINE_CRYSTAL, $meta, $count, "Prismarine Crystal");
	}

}

