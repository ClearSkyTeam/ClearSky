<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\Player;
use pocketmine\tile\Hopper as HopperTile;
use pocketmine\tile\Tile;

class Hopper extends Solid{

	protected $id = self::HOPPER_BLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Hopper";
	}

	public function canBeActivated(){
		return true;
	}

	public function getHardness(){
		return 3.5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$faces = [
			0 => 0,
			1 => 0,
			2 => 3,
			3 => 2,
			4 => 5,
			5 => 4,
		];
		$this->meta = $faces[$face];
		$this->getLevel()->setBlock($block, $this, true, true);
		$nbt = new CompoundTag("", [
			new ListTag("Items", []),
			new StringTag("id", Tile::HOPPER),
			new IntTag("x", $this->x),
			new IntTag("y", $this->y),
			new IntTag("z", $this->z)
		]);
		$nbt->Items->setTagType(NBT::TAG_Compound);

		if($item->hasCustomName()){
			$nbt->CustomName = new StringTag("CustomName", $item->getCustomName());
		}

		if($item->hasCustomBlockData()){
			foreach($item->getCustomBlockData() as $key => $v){
				$nbt->{$key} = $v;
			}
		}

		Tile::createTile(Tile::HOPPER, $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);

		return true;
	}

	public function onActivate(Item $item, Player $player = null){
		if($player instanceof Player){
			$t = $this->getLevel()->getTile($this);
			$hopper = null;
			if($t instanceof HopperTile){
				$hopper = $t;
			}else{
				$nbt = new CompoundTag("", [
					new ListTag("Items", []),
					new StringTag("id", Tile::HOPPER),
					new IntTag("x", $this->x),
					new IntTag("y", $this->y),
					new IntTag("z", $this->z)
				]);
				$nbt->Items->setTagType(NBT::TAG_Compound);
				$hopper = Tile::createTile(Tile::HOPPER, $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);
			}

			if(isset($hopper->namedtag->Lock) and $hopper->namedtag->Lock instanceof StringTag){
				if($hopper->namedtag->Lock->getValue() !== $item->getCustomName()){
					return true;
				}
			}
			$player->addWindow($hopper->getInventory());
		}

		return true;
	}

	public function getDrops(Item $item){
		$drops = [];
		if($item->isPickaxe() >= 1){
			$drops[] = [Item::HOPPER, 0, 1];
		}

		return $drops;
	}
}