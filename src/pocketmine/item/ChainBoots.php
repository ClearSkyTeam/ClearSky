<?php
namespace pocketmine\item;


class ChainBoots extends Armor{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::CHAIN_BOOTS, $meta, $count, "Chainmail Boots");
	}
	
	public function isArmor(){
		return true;
	}
}