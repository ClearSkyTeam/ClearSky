<?php
namespace pocketmine\tile;

use pocketmine\item\Item;
use pocketmine\level\format\FullChunk;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\Byte;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Float;
use pocketmine\nbt\tag\Int;
use pocketmine\nbt\tag\String;
use pocketmine\tile\Spawnable;
use pocketmine\tile\Tile;

class ItemFrame extends Spawnable {

	public function __construct(FullChunk $chunk, Compound $nbt){
		if(!isset($nbt->Item) or !($nbt->Item instanceof Compound)){
			$tag = NBT::putItemHelper(Item::get(Item::AIR));
			$tag->setName("Item");
			$nbt->Item = $tag;
		}

		if(!isset($nbt->ItemDropChance)){
			$nbt->ItemDropChance = new Float("ItemDropChance", 1.0);
		}

		if(!isset($nbt->ItemRotation)){
			$nbt->ItemRotation = new Byte("ItemRotation", 0);
		}
		
		parent::__construct($chunk, $nbt);
	}

	public function getItem(){
		return NBT::getItemHelper($this->namedtag["Item"]);
	}

	public function setItem(Item $item){
		$tag = NBT::putItemHelper($item);
		$tag->setName("Item");
		$this->namedtag->Item = $tag;

		$this->spawnToAll();

		if($this->chunk){
			$this->chunk->setChanged();
			$this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
		}
	}

	public function getItemDropChance(){
		return $this->namedtag["ItemDropChance"];
	}

	public function setItemDropChance($chance = 1){
		$this->namedtag->ItemDropChance = new Float("ItemDropChance", $chance);
	}

	public function getItemRotation(){
		return $this->namedtag["ItemRotation"];
	}

	public function setItemRotation($rot){
		$this->namedtag->ItemRotation = new Byte("ItemRotation", $rot);

		$this->spawnToAll();

		if($this->chunk){
			$this->chunk->setChanged();
			$this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
		}
	}

	public function getSpawnCompound(){
		return new Compound("", [
			new String("id", Tile::ITEM_FRAME),
			new Int("x", (int) $this->x),
			new Int("y", (int) $this->y),
			new Int("z", (int) $this->z),
			$this->namedtag["Item"],
			new Float("ItemDropChance", $this->namedtag["ItemDropChance"]),
			new Byte("ItemRotation", $this->namedtag["ItemRotation"])
		]);	
	}
}