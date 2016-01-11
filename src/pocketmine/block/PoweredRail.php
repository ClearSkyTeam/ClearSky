<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\math\Vector3;

class PoweredRail extends ExtendedRailBlock implements RedstoneConsumer{

	protected $id = self::POWERED_RAIL;
	const SIDE_NORTH_WEST = 6;
	const SIDE_NORTH_EAST = 7;
	const SIDE_SOUTH_EAST = 8;
	const SIDE_SOUTH_WEST = 9;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Powered Rail";
	}

	public function getHardness(){
		return 0.1;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			if($this->getSide(0) instanceof Transparent){
				$this->getLevel()->useBreakOn($this);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}

	public function onRedstoneUpdate($type,$power){
		if($this->isActivitedByRedstone() && !$this->isPowered()){
			$this->togglePowered();
		}
		elseif(!$this->isActivitedByRedstone() && $this->isPowered()){
			$this->togglePowered();
		}
	}

	public function getDrops(Item $item){
		return [[Item::POWERED_RAIL, 0, 1]];
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

	public function setDirection($face, $isOnSlope=false){
		$extrabitset=(($this->meta&0x08)===0x08);
		if($face !== Vector3::SIDE_WEST && $face !== Vector3::SIDE_EAST && $face !== Vector3::SIDE_NORTH && $face !== Vector3::SIDE_SOUTH){
			throw new IllegalArgumentException("This rail variant can't be on a curve!");
		}
		$this->meta=($extrabitset?($this->meta|0x08):($this->meta&~0x08));
		$this->getLevel()->setBlock($this, Block::get($this->id, $this->meta));
	}
	
	public function isCurve(){
		return false;
	}
	
	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down=$block->getSide(Vector3::SIDE_DOWN);
		if($down->isTransparent() === false){
			$this->getLevel()->setBlock($this, Block::get($this->id,0));
			$up=$block->getSide(Vector3::SIDE_UP);
			if($block->getSide(Vector3::SIDE_EAST)&&$block->getSide(Vector3::SIDE_WEST)){
				if($up->getSide(Vector3::SIDE_EAST)){
					$this->setDirection(Vector3::SIDE_EAST,true);
				}
				elseif($up->getSide(Vector3::SIDE_WEST)){
					$this->setDirection(Vector3::SIDE_WEST,true);
				}
				else{
					$this->setDirection(Vector3::SIDE_EAST);
				}
			}
			elseif($block->getSide(Vector3::SIDE_SOUTH)&&$block->getSide(Vector3::SIDE_NORTH)){
				if($up->getSide(Vector3::SIDE_SOUTH)){
					$this->setDirection(Vector3::SIDE_SOUTH,true);
				}
				elseif($up->getSide(Vector3::SIDE_NORTH)){
					$this->setDirection(Vector3::SIDE_NORTH,true);
				}
				else{
					$this->setDirection(Vector3::SIDE_SOUTH);
				}
			}
			else{
				$this->setDirection(Vector3::SIDE_NORTH);
			}
			return true;
		}
		return false;
	}

	public function getDirection(){
		switch($this->meta){
			case 0:
				{
					return Vector3::SIDE_SOUTH;
				}
			case 1:
				{
					return Vector3::SIDE_EAST;
				}
			case 2:
				{
					return Vector3::SIDE_EAST;
				}
			case 3:
				{
					return Vector3::SIDE_WEST;
				}
			case 4:
				{
					return Vector3::SIDE_NORTH;
				}
			case 5:
				{
					return Vector3::SIDE_SOUTH;
				}
			case 6:
				{
					return self::SIDE_NORTH_WEST;
				}
			case 7:
				{
					return self::SIDE_NORTH_EAST;
				}
			case 8:
				{
					return self::SIDE_SOUTH_EAST;
				}
			case 9:
				{
					return self::SIDE_SOUTH_WEST;
				}
			default:
				{
					return Vector3::SIDE_SOUTH;
				}
		}
	}

	public function __toString(){
		$this->getName() . " facing " . $this->getDirection() . ($this->isCurve()?" on a curve ":($this->isOnSlope()?" on a slope":""));
	}

	public function isOnSlope(){
		$d = $this->meta;
		return ($d == 0x02 || $d == 0x03 || $d == 0x04 || $d == 0x05);
	}
}