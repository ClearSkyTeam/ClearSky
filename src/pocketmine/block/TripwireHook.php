<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\math\Vector3;

class TripwireHook extends Flowable{
	protected $id = self::TRIPWIRE_HOOK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness(){
		return 0;
	}

	public function isSolid(){
		return false;
	}

	public function getName(){
		return "Tripwire Hook";
	}

	public function getBoundingBox(){
		return null;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		if($face !== 0 && $face !== 1){
			$ret = $this->setFacingDirection($face);
			$this->getLevel()->setBlock($block, $this, true);
			return $ret;
		}
		
		return false;
	}
	
	public function getDrops(Item $item){
		return [
			[Item::TRIPWIRE_HOOK, 0, 1],
		];
	}


	/**
	 * Test if tripwire is connected
	 *
	 * @return true if connected, false if not
	 */
	public function isConnected() {
		return ($this->getDamage() & 0x04) != 0;
	}
	
	/**
	 * Set tripwire connection state
	 *
	 * @param connected - true if connected, false if not
	 */
	public function setConnected($connected) {
		$dat = $this->getDamage() & (0x08 | 0x03);
		if ($connected) {
			$dat |= 0x04;
		}
		$this->setDamage($dat);
	}
	
	/**
	 * Test if hook is currently activated
	 *
	 * @return true if activated, false if not
	 */
	public function isActivated() {
		return ($this->getDamage() & 0x08) != 0;
	}
	
	/**
	 * Set hook activated state
	 *
	 * @param act - true if activated, false if not
	 */
	public function setActivated($act) {
		$dat = $this->getDamage() & (0x04 | 0x03);
		if ($act) {
			$dat |= 0x08;
		}
		$this->setDamage($dat);
	}
	
	public function setFacingDirection($face) {
		$dat = $this->getDamage() & 0x0C;
		switch ($face) {
			case Vector3::SIDE_WEST:
				$dat |= 0x01;
				break;
			case Vector3::SIDE_NORTH:
				$dat |= 0x02;
				break;
			case Vector3::SIDE_EAST:
				$dat |= 0x03;
				break;
			case Vector3::SIDE_SOUTH:
			default:
				return false;
				break;
		}
		$this->setDamage($dat);
	}
	
	public function getAttachedFace() {
		switch ($this->getDamage() & 0x03) {
			case 0:
				return Vector3::SIDE_NORTH;
			case 1:
				return Vector3::SIDE_EAST;
			case 2:
				return Vector3::SIDE_SOUTH;
			case 3:
				return Vector3::SIDE_WEST;
		}
		return null;
	}
	
	public function isPowered() {
		return $this->isActivated();
	}
	
	public function __toString() {
		return $this->getName() . " facing " . $this->getFacing() . ($this->isActivated()?" Activated":"") . ($this->isConnected()?" Connected":"");
	}
}