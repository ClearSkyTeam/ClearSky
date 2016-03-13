<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Float;
use pocketmine\nbt\tag\Int;
use pocketmine\nbt\tag\Byte;
use pocketmine\nbt\tag\String;
use pocketmine\tile\Tile;
use pocketmine\tile\ItemFrame as ItemFrameTile;
use pocketmine\Player;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\Short;

class ItemFrame extends Transparent{
	protected $id = self::ITEM_FRAME_BLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Item Frame";
	}

	public function canBeActivated(){
		return true;
	}

	public function onActivate(Item $item, Player $player = null){
		if($player instanceof Player){
			$t = $this->getLevel()->getTile($this);
			$tile = null;
			if($t instanceof ItemFrameTile){
				$tile = $t;
			}
			else{
				$nbt = new Compound("", [
			new String("id", Tile::ITEM_FRAME),
			new Int("x", (int) $this->x),
			new Int("y", (int) $this->y),
			new Int("z", (int) $this->z),
			new Short("item", 0),
			new Int("mData", 0),
			new Byte("ItemRotation", 0),
			new Float("ItemDropChance", 1.0),
		]);/*
				$nbt = new Compound("", [
					new String("id", Tile::ITEM_FRAME),
					new Int("x", $this->x),
					new Int("y", $this->y),
					new Int("z", $this->z),
					new Short("Item", 0),
					new Byte("ItemRotation", 0),
					new Float("ItemDropChance", 1.0)
				]);*/
				#$nbt->Item->setTagType(NBT::TAG_Compound);
				$tile = Tile::createTile("ItemFrame", $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);
			}
			if(is_null($tile)) return false;
			if($tile->getItem()->getId() === 0){
				$tile->setItem(Item::get($item->getId(), $item->getDamage(), 1));
				if($player->isSurvival()){
					$count = $item->getCount();
					if(--$count <= 0){
						$player->getInventory()->setItemInHand(Item::get(Item::AIR));
						return true;
					}
					
					$item->setCount($count);
					$player->getInventory()->setItemInHand($item);
				}
			}
			else{
				$itemRot = $tile->getItemRotation();
				if($itemRot === 7) $itemRot = 0;
				else $itemRot++;
				$tile->setItemRotation($itemRot);
			}
		}
		
		return true;
	}

	public function onBreak(Item $item){
		$this->getLevel()->setBlock($this, new Air(), true, false);
	}

	public function getDrops(Item $item){
		$tile = $this->getLevel()->getTile($this);
		if(!$tile instanceof ItemFrameTile){
			return [
				[Item::ITEM_FRAME, 0, 1]
			];
		}
		$chance = mt_rand(0, 100);
		if($chance <= ($tile->getItemDropChance() * 100)){
			return [
				[Item::ITEM_FRAME, 0 ,1],
				[$tile->getItem()->getId(), $tile->getItem()->getDamage(), 1]
			];
		}
		return [
			[Item::ITEM_FRAME, 0 ,1]
		];
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		if($target->isTransparent() === false and $face > 1 and $block->isSolid() === false){
			$faces = [
				2 => 3,
				3 => 2,
				4 => 1,
				5 => 0,
			];
			$this->meta = $faces[$face];
			$this->getLevel()->setBlock($block, $this, true, true);
			/*$nbt = new Compound("", [
				new String("id", Tile::ITEM_FRAME),
				new Int("x", $this->x),
				new Int("y", $this->y),
				new Int("z", $this->z),
				new Short("Item", 0),
				new Byte("ItemRotation", 0),
				new Float("ItemDropChance", 1.0)
			]);*/
			#$nbt->Item->setTagType(NBT::TAG_Compound);
				$nbt = new Compound("", [
			new String("id", Tile::ITEM_FRAME),
			new Int("x", (int) $this->x),
			new Int("y", (int) $this->y),
			new Int("z", (int) $this->z),
			new Short("item", 0),
			new Int("mData", 0),
			new Byte("ItemRotation", 0),
			new Float("ItemDropChance", 1.0),]);
			Tile::createTile("ItemFrame", $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);
			return true;
			}
		return false;
	}
}