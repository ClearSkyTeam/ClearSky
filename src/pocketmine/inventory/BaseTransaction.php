<?php
namespace pocketmine\inventory;

use pocketmine\item\Item;

class BaseTransaction implements Transaction{
	/** @var Inventory */
	protected $inventory;
	/** @var int */
	protected $slot;
	/** @var Item */
	protected $sourceItem;
	/** @var Item */
	protected $targetItem;
	/** @var float */
	protected $creationTime;

	/**
	 * @param Inventory $inventory
	 * @param int       $slot
	 * @param Item      $sourceItem
	 * @param Item      $targetItem
	 */
	public function __construct(Inventory $inventory, $slot, Item $sourceItem, Item $targetItem){
		$this->inventory = $inventory;
		$this->slot = (int) $slot;
		$this->sourceItem = clone $sourceItem;
		$this->targetItem = clone $targetItem;
		$this->creationTime = microtime(true);
	}

	public function getCreationTime(){
		return $this->creationTime;
	}

	public function getInventory(){
		return $this->inventory;
	}

	public function getSlot(){
		return $this->slot;
	}

	public function getSourceItem(){
		return clone $this->sourceItem;
	}

	public function getTargetItem(){
		return clone $this->targetItem;
	}
}