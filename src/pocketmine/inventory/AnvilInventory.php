<?php
namespace pocketmine\inventory;

use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\Player;

class AnvilInventory extends ContainerInventory{
	public function __construct(Position $pos){
		parent::__construct(new FakeBlockMenu($this, $pos), InventoryType::get(InventoryType::ANVIL));
	}
	/**
	 * @return FakeBlockMenu
	 */
	public function getHolder(){
		return $this->holder;
	}

	public function onRename(Item $item, Player $player){
		if($player->getXpLevel() > $item->getRepairCost()){
			$player->setXpLevel($player->getXpLevel() - $item->getRepairCost());
			return true;
		}
		return false;
	}

	public function onClose(Player $who){
		$who->recalculateXpProgress();
		parent::onClose($who);
		$this->getHolder()->getLevel()->dropItem($this->getHolder()->add(0.5, 0.5, 0.5), $this->getItem(0));
		$this->getHolder()->getLevel()->dropItem($this->getHolder()->add(0.5, 0.5, 0.5), $this->getItem(1));
		$this->clear(0);
		$this->clear(1);
		$this->clear(2);
	}
}