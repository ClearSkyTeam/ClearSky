<?php
namespace pocketmine\item;

class PrismarineShard extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::PRISMARINE_SHARD, $meta, $count, "Prismarine Shard");
	}

}

