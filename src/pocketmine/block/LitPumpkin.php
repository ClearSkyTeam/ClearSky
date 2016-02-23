<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\Player;

class LitPumpkin extends Solid{
	protected $id = self::LIT_PUMPKIN;

	public function getLightLevel(){
		return 15;
	}
	
	public function isLightSource(){
		return true;
	}

	public function getHardness(){
		return 1;
	}

	public function getToolType(){
		return Tool::TYPE_AXE;
	}

	public function getName(){
		return "Jack o'Lantern";
	}

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $block->getSide(0);
		if($down->isTransparent() && !($down instanceof Slab && ($down->meta & 0x08) === 0x08) || ($down instanceof WoodSlab && ($down->meta & 0x08) === 0x08) || ($down instanceof Stair && ($down->meta & 0x04) === 0x04)){
			return false;
		}
		if($player instanceof Player){
			$this->meta = ((int) $player->getDirection() + 5) % 4;
		}
		$this->getLevel()->setBlock($block, $this, true, true);
		
		return true;
	}
}