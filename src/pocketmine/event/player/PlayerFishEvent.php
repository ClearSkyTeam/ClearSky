<?php
namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\Player;

class PlayerFishEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;
	/** @var Item */
	private $item;
	/**
	 * @param Player $player
	 * @param Item   $item
	 * @param $fishingHook
	 */
	public function __construct(Player $player, Item $item, $fishingHook = null){
		$this->player = $player;
		$this->item = $item;
		$this->hook = $fishingHook;
	}
	/**
	 * @return Item
	 */
	public function getItem(){
		return clone $this->item;
	}
	public function getHook(){
		return $this->hook;
	}
}
