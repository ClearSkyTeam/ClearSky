<?php
namespace pocketmine\event\inventory;

use pocketmine\event\block\BlockEvent;
use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\tile\Furnace;

class FurnaceBurnEvent extends BlockEvent implements Cancellable{
	public static $handlerList = null;

	private $furnace;
	private $fuel;
	private $burnTime;
	private $burning = true;

	public function __construct(Furnace $furnace, Item $fuel, $burnTime){
		parent::__construct($furnace->getBlock());
		$this->fuel = $fuel;
		$this->burnTime = (int) $burnTime;
		$this->furnace = $furnace;
	}

	/**
	 * @return Furnace
	 */
	public function getFurnace(){
		return $this->furnace;
	}

	/**
	 * @return Item
	 */
	public function getFuel(){
		return $this->fuel;
	}

	/**
	 * @return int
	 */
	public function getBurnTime(){
		return $this->burnTime;
	}

	/**
	 * @param int $burnTime
	 */
	public function setBurnTime($burnTime){
		$this->burnTime = (int) $burnTime;
	}

	/**
	 * @return bool
	 */
	public function isBurning(){
		return $this->burning;
	}

	/**
	 * @param bool $burning
	 */
	public function setBurning($burning){
		$this->burning = (bool) $burning;
	}
}