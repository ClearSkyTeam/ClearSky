<?php
namespace pocketmine\block;

use pocketmine\item\Item;

class NetherWart extends NetherCrops{
	protected $id = self::NETHER_WART_BLOCK;
	
	public function __construct($meta = 0){
		$this->meta = $meta;
	}
	public function getName(){
		return "Nether Wart Block";
	}

    public function getDrops(Item $item){
        $drops = [];
        if($this->meta >= 0x03){
            $drops[] = [Item::NETHER_WART, 0, mt_rand(2, 4)];
        }else{
            $drops[] = [Item::NETHER_WART, 0, 1];
        }

        return $drops;
	}
}
