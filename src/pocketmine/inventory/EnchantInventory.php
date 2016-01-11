<?php
namespace pocketmine\inventory;

use pocketmine\level\Position;
use pocketmine\Player;

class EnchantInventory extends ContainerInventory{
	public function __construct(Position $pos){
		parent::__construct(new FakeBlockMenu($this, $pos), InventoryType::get(InventoryType::ENCHANT_TABLE));
	}

	/**
	 * @return FakeBlockMenu
	 */
	public function getHolder(){
		return $this->holder;
	}

	public function onClose(Player $who){
		parent::onClose($who);

		for($i = 0; $i < 2; ++$i){
			$this->getHolder()->getLevel()->dropItem($this->getHolder()->add(0.5, 0.5, 0.5), $this->getItem($i));
			$this->clear($i);
		}
	}
}