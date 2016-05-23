<?php
namespace pocketmine\tile;

use pocketmine\block\Block;
use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;

class FlowerPot extends Spawnable{

	public function __construct(FullChunk $chunk, Compound $nbt){
		if(!isset($nbt->item)){
			$nbt->item = new ShortTag("item", 0);
		}
		if(!isset($nbt->mData)){
			$nbt->mData = new IntTag("mData", 0);
		}
		parent::__construct($chunk, $nbt);
	}

	public function getFlowerPotItem(){
		return $this->namedtag["item"];
	}

	public function getFlowerPotData(){
		return $this->namedtag["mData"];
	}

	/**
	 * @param int $item        	
	 * @param int $data        	
	 */
	public function setFlowerPotData($item, $data){
		$this->namedtag->item = new ShortTag("item", (int) $item);
		$this->namedtag->mData = new IntTag("mData", (int) $data);
		$this->spawnToAll();
		if($this->chunk){
			$this->chunk->setChanged();
			$this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
			$block = $this->level->getBlock($this);
			if($block->getId() === Block::FLOWER_POT_BLOCK){
				$this->level->setBlock($this, Block::get(Block::FLOWER_POT_BLOCK, ($block->getDamage() === 0 ? 1:0)), true);
			}
		}
		return true;
	}

	public function getSpawnCompound(){
		return new CompoundTag("", [
			new StringTag("id", Tile::FLOWER_POT),
			new IntTag("x", (int) $this->x),
			new IntTag("y", (int) $this->y),
			new IntTag("z", (int) $this->z),
			new ShortTag("item", (int) $this->namedtag["item"]),
			new IntTag("mData", (int) $this->namedtag["mData"])
		]);
	}
}