<?php
namespace pocketmine\metadata;

use pocketmine\Block\Block;
use pocketmine\level\Level;
use pocketmine\plugin\Plugin;

class BlockMetadataStore extends MetadataStore{
	/** @var Level */
	private $owningLevel;

	public function __construct(Level $owningLevel){
		$this->owningLevel = $owningLevel;
	}

	public function disambiguate(Metadatable $block, $metadataKey){
		if(!($block instanceof Block)){
			throw new \InvalidArgumentException("Argument must be a Block instance");
		}

		return $block->x . ":" . $block->y . ":" . $block->z . ":" . $metadataKey;
	}

	public function getMetadata($block, $metadataKey){
		if(!($block instanceof Block)){
			throw new \InvalidArgumentException("Object must be a Block");
		}
		if($block->getLevel() === $this->owningLevel){
			return parent::getMetadata($block, $metadataKey);
		}else{
			throw new \InvalidStateException("Block does not belong to world " . $this->owningLevel->getName());
		}
	}

	public function hasMetadata($block, $metadataKey){
		if(!($block instanceof Block)){
			throw new \InvalidArgumentException("Object must be a Block");
		}
		if($block->getLevel() === $this->owningLevel){
			return parent::hasMetadata($block, $metadataKey);
		}else{
			throw new \InvalidStateException("Block does not belong to world " . $this->owningLevel->getName());
		}
	}

	public function removeMetadata($block, $metadataKey, Plugin $owningPlugin){
		if(!($block instanceof Block)){
			throw new \InvalidArgumentException("Object must be a Block");
		}
		if($block->getLevel() === $this->owningLevel){
			parent::hasMetadata($block, $metadataKey, $owningPlugin);
		}else{
			throw new \InvalidStateException("Block does not belong to world " . $this->owningLevel->getName());
		}
	}

	public function setMetadata($block, $metadataKey, MetadataValue $newMetadatavalue){
		if(!($block instanceof Block)){
			throw new \InvalidArgumentException("Object must be a Block");
		}
		if($block->getLevel() === $this->owningLevel){
			parent::setMetadata($block, $metadataKey, $newMetadatavalue);
		}else{
			throw new \InvalidStateException("Block does not belong to world " . $this->owningLevel->getName());
		}
	}
}