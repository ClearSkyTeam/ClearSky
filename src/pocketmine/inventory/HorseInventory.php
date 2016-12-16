<?php

namespace pocketmine\inventory;

use pocketmine\Player;
use pocketmine\inventory\ContainerInventory;
use pocketmine\inventory\InventoryType;
use pocketmine\entity\Horse;

class HorseInventory extends ContainerInventory{
	/** @var InventoryHolder */
	protected $holder;

	public function __construct(Horse $horse){
		parent::__construct($horse, InventoryType::get(InventoryType::HORSE)/*, [], null, $horse->getName()*/);
	}

	/**
	 *
	 * @return Horse
	 */
	public function getHolder(){
		return $this->holder;
	}

	public function onClose(Player $who){
		parent::onClose($who);
	}
}