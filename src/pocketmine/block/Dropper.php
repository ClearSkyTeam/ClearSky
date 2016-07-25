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
use pocketmine\tile\Dropper as DropperTile;
use pocketmine\tile\Tile;
use pocketmine\level\Level;

class Dropper extends Solid implements RedstoneConsumer{
	protected $id = self::DROPPER;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Dropper";
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

	public function BroadcastRedstoneUpdate($type,$power){
		for($side = 0; $side <= 5; $side++){
			$currentBlock = $this->getSide($side);
			$this->getLevel()->setRedstoneUpdate($currentBlock,Block::REDSTONEDELAY,$type,$power);
		}
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_SCHEDULED){
			if($this->isPowered()){
				$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_BLOCK,Block::REDSTONESOURCEPOWER);
				$this->getLevel()->scheduleUpdate($this, 1);
			}else{
				$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_BLOCK,0);
			}
		}
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		if($player instanceof Player){
			$pitch = $player->getPitch();
			if(abs($pitch) >= 45){
				if($pitch < 0) $f = 0;
				else $f = 1;
			}
			else
				$f = $player->getDirection() + 2;
		}
		else
			$f = 0;
		$faces = [0 => 0, 1 => 1, 2 => 4, 3 => 2, 4 => 5, 5 => 3];
		$this->meta = $faces[$f];
		$this->getLevel()->setBlock($block, $this, true, true);
		$nbt = new CompoundTag("", [
			new ListTag("Items", []),
			new StringTag("id", Tile::DROPPER),
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
		Tile::createTile(Tile::DROPPER, $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);
		return true;
	}

	public function onActivate(Item $item, Player $player = null){
		if($player instanceof Player){
			$t = $this->getLevel()->getTile($this);
			$dropper = null;
			if($t instanceof DropperTile){
				$dropper = $t;
			}else{
				$nbt = new CompoundTag("", [
					new ListTag("Items", []),
					new StringTag("id", Tile::DROPPER),
					new IntTag("x", $this->x),
					new IntTag("y", $this->y),
					new IntTag("z", $this->z)
				]);
				$nbt->Items->setTagType(NBT::TAG_Compound);
				$dropper = Tile::createTile(Tile::DROPPER, $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);
			}

			if(isset($dropper->namedtag->Lock) and $dropper->namedtag->Lock instanceof StringTag){
				if($dropper->namedtag->Lock->getValue() !== $item->getCustomName()){
					return true;
				}
			}
			$player->addWindow($dropper->getInventory());
		}

		return true;
	}

	public function getDrops(Item $item){
		return [[$this->id,0,1]];
	}
	
	public function onRedstoneUpdate($type, $power){
		if($type !== Level::REDSTONE_UPDATE_REPOWER && $type !== Level::REDSTONE_UPDATE_PLACE) return;
		if($this->isPowered()){
			$this->activate();
			$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_BLOCK,Block::REDSTONESOURCEPOWER);
			$this->getLevel()->scheduleUpdate($this, 1);
		}
	}

	public function activate(){
		$tile = $this->getLevel()->getTile($this);
		if($tile instanceof DropperTile){
			$tile->activate();
		}
	}
}