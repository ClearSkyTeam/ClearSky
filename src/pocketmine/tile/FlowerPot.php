<?php
namespace pocketmine\tile;

use pocketmine\block\Block;
use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Int;
use pocketmine\nbt\tag\Short;
use pocketmine\nbt\tag\String;
use pocketmine\tile\Tile;

class FlowerPot extends Spawnable{

	public function __construct(FullChunk $chunk, Compound $nbt){
		if(!isset($nbt->item)){
			$nbt->item = new Short("item", 0);
		}
		if(!isset($nbt->mData)){
			$nbt->mData = new Int("mData", 0);
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
		$this->namedtag->item = new Short("item", (int) $item);
		$this->namedtag->mData = new Int("mData", (int) $data);
		$this->spawnToAll();
		if($this->chunk){
			$this->chunk->setChanged();
			$this->level->clearChunkCache($this->chunk->getX(), $this->chunk->getZ());
			$block = $this->level->getBlock($this);
			if($block->getId() === Block::FLOWER_POT_BLOCK){
				$this->level->updateBlock($block);
				$this->level->setBlock($this, Block::get(Block::FLOWER_POT_BLOCK, ($block->getDamage() === 0 ? 1:0)), true);
			}
		}
		return true;
	}

	public function getSpawnCompound(){
		return new Compound("", [
			new String("id", Tile::FLOWER_POT),
			new Int("x", (int) $this->x),
			new Int("y", (int) $this->y),
			new Int("z", (int) $this->z),
			new Short("item", (int) $this->namedtag["item"]),
			new Int("mData", (int) $this->namedtag["mData"])
		]);
	}
}