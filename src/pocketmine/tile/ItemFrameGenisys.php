<?php
namespace pocketmine\tile;

use pocketmine\item\Item;
use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\Byte;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Float;
use pocketmine\nbt\tag\Int;
use pocketmine\nbt\tag\String;
use pocketmine\nbt\tag\Short;

class ItemFrameGenisys extends Spawnable{

	public function __construct(FullChunk $chunk, Compound $nbt){
		if(!isset($nbt->Item)){
			$nbt->Item = new Short("Item", 0);
		}
		if(!isset($nbt->ItemRotation)){
			$nbt->ItemRotation = new Byte("ItemRotation", 0);
		}
		if(!isset($nbt->ItemDropChance)){
			$nbt->ItemDropChance = new Float("ItemDropChance", 1.0);
		}

		parent::__construct($chunk, $nbt);
	}

	public function saveNBT(){
		parent::saveNBT();
	}

	public function getName(){
		return "Item Frame";
	}
/*
	public function getItemRotation(){
		return $this->namedtag["ItemRotation"];
	}

	public function setItemRotation($itemRotation){
		$this->namedtag->ItemRotation = new Byte("ItemRotation", $itemRotation);
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
		$this->namedtag->ItemDropChance = new Float("ItemDropChance", $chance);
	}

	private function setChanged(){
		$this->spawnToAll();
		if($this->chunk instanceof FullChunk){
			$this->chunk->setChanged();
			$this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
		}
	}*/

	public function getSpawnCompound(){
		return new Compound("", [
			new String("id", Tile::ITEM_FRAME),
			new Int("x", (int) $this->x),
			new Int("y", (int) $this->y),
			new Int("z", (int) $this->z),
			new Short("Item", $this->getItem()),
			new Byte("ItemRotation", $this->getItemRotation()),
			new Float("ItemDropChance", $this->getItemDropChance())
		]);
	}
}