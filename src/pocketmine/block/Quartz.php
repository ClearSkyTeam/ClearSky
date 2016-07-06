<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\block\Block;
use pocketmine\Player;

class Quartz extends Solid{

	const QUARTZ_NORMAL = 0;
	const QUARTZ_CHISELED = 1;
	const QUARTZ_PILLAR = 2;
    
	protected $id = self::QUARTZ_BLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness(){
		return 0.8;
	}
	
	public function getName(){
		static $names = [
			self::QUARTZ_NORMAL => "Quartz Block",
			self::QUARTZ_CHISELED => "Chiseled Quartz Block",
			self::QUARTZ_PILLAR => "Quartz Pillar",
		];
		return $names[$this->meta & 0x03];
	}
	
	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		if($this->meta === 1 or $this->meta === 2){
			$faces = [
				0 => 0,
				1 => 0,
				2 => 0b1000,
				3 => 0b1000,
				4 => 0b0100,
				5 => 0b0100,
			];
	
			$this->meta = ($this->meta & 0x03) | $faces[$face];
		}
		$this->getLevel()->setBlock($block, $this, true, true);

		return true;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[Item::QUARTZ_BLOCK, $this->meta & 0x03, 1],
			];
		}else{
			return [];
		}
	}
}
