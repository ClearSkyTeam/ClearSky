<?php
namespace pocketmine\block;

use pocketmine\inventory\AnvilInventory;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\Player;
use pocketmine\level\sound\AnvilFallSound;

class AnvilBlock extends Fallable{
	const TYPE_ANVIL = 0;
	const TYPE_SLIGHTLY_DAMAGED_ANVIL = 4;
	const TYPE_VERY_DAMAGED_ANVIL = 8;

	protected $id = self::ANVIL_BLOCK;

	public function isSolid(){
		return false;
	}

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function canBeActivated(){
		return true;
	}

	public function getHardness(){
		return 5;
	}

	public function getResistance(){
		return 6000;
	}

	public function getName(){
		static $names = [
			self::TYPE_ANVIL => "Anvil",
			self::TYPE_SLIGHTLY_DAMAGED_ANVIL => "Slighty Damaged Anvil",
			self::TYPE_VERY_DAMAGED_ANVIL => "Very Damaged Anvil",
			12 => "Anvil" //just in case 
		];
		return $names[$this->meta & 0x0c];
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function onActivate(Item $item, Player $player = null){
		if($player instanceof Player){
			$player->addWindow(new AnvilInventory($this));
		}
		return true;
	}

	public function getDrops(Item $item){
		$damage = $this->getDamage();
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[$this->id, $this->meta & 0x0c, 1],
			];
		}else{
			return [];
		}
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$this->getLevel()->addSound(new AnvilFallSound($this));
		if($target->isTransparent() === false){
			$direction = ($player !== null? $player->getDirection(): 0) & 0x03;
			$this->meta = ($this->meta & 0x0c) | $direction;
			$this->getLevel()->setBlock($block, $this, true, true);
			return true;
		}
		return false;
	}
}
