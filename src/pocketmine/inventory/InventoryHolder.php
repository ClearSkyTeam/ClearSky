<?php
namespace pocketmine\inventory;

interface InventoryHolder{

	/**
	 * Get the object related inventory
	 *
	 * @return Inventory
	 */
	public function getInventory();
}