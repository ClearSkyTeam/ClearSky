<?php
namespace pocketmine\inventory;

use pocketmine\item\Item;

interface Transaction{

	/**
	 * @return Inventory
	 */
	public function getInventory();

	/**
	 * @return int
	 */
	public function getSlot();

	/**
	 * @return Item
	 */
	public function getSourceItem();

	/**
	 * @return Item
	 */
	public function getTargetItem();

	/**
	 * @return float
	 */
	public function getCreationTime();
}