<?php
namespace beito\FlowerPot\extra\ItemFrame;

use pocketmine\block\Block;
use pocketmine\event\block\BlockEvent;
use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\Player;

class ItemFrameDropItemEvent extends BlockEvent implements Cancellable{
	public static $handlerList = null;

	/** @var \pocketmine\Player */
	private $player;
	/** @var \pocketmine\item\Item */
	private $item;
	private $dropChance;

	/**
	 * @param Block    $block
	 * @param Player   $player
	 * @param Item     $dropItem
	 * @param FloatTag    $dropChance
	 */
	public function __construct(Block $block, Player $player, Item $dropItem, $dropChance){
		parent::__construct($block);
		$this->player = $player;
		$this->item = $dropItem;
		$this->dropChance = (float) $dropChance;
	}

	/**
	 * @return Player
	 */
	public function getPlayer(){
		return $this->player;
	}

	/**
	 * @return Item
	 */
	public function getDropItem(){
		return $this->item;
	}

	public function setDropItem(Item $item){
		$this->item = $item;
	}

	/**
	 * @return FloatTag
	 */
	public function getItemDropChance(){
		return $this->dropChance;
	}

	public function setItemDropChance($chance){
		$this->dropChance = (float) $chance;
	}
}