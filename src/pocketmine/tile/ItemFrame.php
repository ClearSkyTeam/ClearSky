<?php
namespace pocketmine\tile;

use pocketmine\item\Item;
use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\ShortTag;

class ItemFrame extends Spawnable{

	public function __construct(FullChunk $chunk, CompoundTag $nbt){
		if(!isset($nbt->Item)){
			$nbt->Item = new ShortTag("Item", 0);
		}
		if(!isset($nbt->ItemRotation)){
			$nbt->ItemRotation = new ByteTag("ItemRotation", 0);
		}
		if(!isset($nbt->ItemDropChance)){
			$nbt->ItemDropChance = new FloatTag("ItemDropChance", 1.0);
		}
		if(!isset($this->namedtag->Item)){
			$this->setItem(Item::get(Item::AIR), false);
		}

		parent::__construct($chunk, $nbt);
	}

	public function saveNBT(){
		parent::saveNBT();
	}

	public function getName(){
		return "Item Frame";
	}

	public function getItemRotation(){
		return $this->namedtag["ItemRotation"];
	}

	public function setItemRotation($itemRotation){
		$this->namedtag->ItemRotation = new ByteTag("ItemRotation", $itemRotation);
		$this->setChanged();
	}

	public function getItem(){
		return $this->namedtag->Item;
	}

	public function setItem(Item $item, $setChanged = true){
		$this->namedtag->Item = $item;
		if($setChanged) $this->setChanged();
	}

	public function getItemDropChance(){
		return $this->namedtag["ItemDropChance"];
	}

	public function setItemDropChance($chance = 1.0){
		$this->namedtag->ItemDropChance = new FloatTag("ItemDropChance", $chance);
	}

	private function setChanged(){
		$this->spawnToAll();
		if($this->chunk instanceof FullChunk){
			$this->chunk->setChanged();
			$this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
		}
	}

	public function getSpawnCompound(){
		if($this->getItem()["id"] == 0){
			return new CompoundTag("", [
				new StringTag("id", Tile::ITEM_FRAME),
				new IntTag("x", (int) $this->x),
				new IntTag("y", (int) $this->y),
				new IntTag("z", (int) $this->z),
				new ByteTag("ItemRotation", 0),
				new FloatTag("ItemDropChance", (float) $this->getItemDropChance())
			]);
		}else{
			return new CompoundTag("", [
				new StringTag("id", Tile::ITEM_FRAME),
				new IntTag("x", (int) $this->x),
				new IntTag("y", (int) $this->y),
				new IntTag("z", (int) $this->z),
				new ShortTag("Item", Item::get($this->getItem()["id"])),
				new ByteTag("ItemRotation", (int) $this->getItemRotation()),
				new FloatTag("ItemDropChance", (float) $this->getItemDropChance())
			]);
		}
	}
}