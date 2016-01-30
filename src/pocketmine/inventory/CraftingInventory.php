<?php
namespace pocketmine\inventory;

/**
 * Manages crafting operations
 * This class includes future methods for shaped crafting
 *
 * TODO: add small matrix inventory
 */
class CraftingInventory extends BaseInventory{

	/** @var Inventory */
	private $resultInventory;

	/**
	 * @param InventoryHolder $holder
	 * @param Inventory       $resultInventory
	 * @param InventoryType   $inventoryType
	 *
	 * @throws \Throwable
	 */
	public function __construct(InventoryHolder $holder, Inventory $resultInventory, InventoryType $inventoryType){
		if($inventoryType->getDefaultTitle() !== "Crafting"){
			throw new \InvalidStateException("Invalid Inventory type, expected CRAFTING or WORKBENCH");
		}
		$this->resultInventory = $resultInventory;
		parent::__construct($holder, $inventoryType);
	}

	/**
	 * @return Inventory
	 */
	public function getResultInventory(){
		return $this->resultInventory;
	}

	public function getSize(){
		return $this->getResultInventory()->getSize() + parent::getSize();
	}
}