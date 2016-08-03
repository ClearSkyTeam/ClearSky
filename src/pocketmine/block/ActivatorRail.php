<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\Player;
use pocketmine\math\Vector3;

class ActivatorRail extends Rail implements RedstoneConsumer{
	protected $id = self::ACTIVATOR_RAIL;
	const SIDE_NORTH_WEST = 6;
	const SIDE_NORTH_EAST = 7;
	const SIDE_SOUTH_EAST = 8;
	const SIDE_SOUTH_WEST = 9;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Activator Rail";
	}

	public function getHardness(){
		return 0.1;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function onRedstoneUpdate($type,$power){
		if($this->isPowered()){
			$this->togglePowered();
		}
	}

	public function getDrops(Item $item){
		return [[Item::ACTIVATOR_RAIL, 0, 1]];
	}

	public function isPowered(){
		return (($this->meta & 0x08) === 0x08);
	}

	/**
	 * Toggles the current state of this plate
	 */
	public function togglePowered(){
		$this->meta ^= 0x08;
		$this->isPowered()?$this->power=15:$this->power=0;
		$this->getLevel()->setBlock($this, $this, true, true);
	}
}