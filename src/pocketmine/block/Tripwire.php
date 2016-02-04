<?php
namespace pocketmine\block;


use pocketmine\item\Item;

use pocketmine\math\AxisAlignedBB;
use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\level\Level;

class Tripwire extends Flowable{

	protected $id = self::TRIPWIRE;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function isSolid(){
		return false;
	}

	public function getName(){
		return "Tripwire";
	}

	public function getHardness(){
		return 0;
	}

	public function canPassThrough(){
		return true;
	}

	protected function recalculateBoundingBox(){
		if($this->getSide(Vector3::SIDE_DOWN) instanceof Transparent){
			return new AxisAlignedBB(
				$this->x,
				$this->y,
				$this->z,
				$this->x + 1,
				$this->y + 0.5,
				$this->z + 1
			);
		}
		else{
			return new AxisAlignedBB(
				$this->x,
				$this->y,
				$this->z,
				$this->x + 1,
				$this->y + 0.09375,
				$this->z + 1
			);
		}
	}

	public function getDrops(Item $item){
		$drops = [];
		$drops[] = [Item::STRING, 0, 1];

		return $drops;
	}
	
	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			$this->recalculateBoundingBox();
		}
		return false;
	}
	
    /**
     * Test if tripwire is currently activated
     *
     * @return true if activated, false if not
     */
    public function isActivated() {
        return ($this->getDamage() & 0x04) != 0;
    }
    
    /**
     * Set tripwire activated state
     *
     * @param $act - true if activated, false if not
     */
    public function setActivated($act) {
        $dat = $this->getDamage() & (0x08 | 0x03);
        if ($act) {
            $dat |= 0x04;
        }
        $this->setDamage($dat);
    }    
    
    /**
     * Test if object triggering this tripwire directly
     *
     * @return true if object activating tripwire, false if not
     */
    public function isObjectTriggering() {
        return ($this->getDamage() & 0x01) != 0;
    }

    /**
     * Set object triggering state for this tripwire
     *
     * @param trig - true if object activating tripwire, false if not
     */
    public function setObjectTriggering($trig) {
        $dat = $this->getDamage() & 0x0E;
        if ($trig) {
            $dat |= 0x01;
        }
        $this->setDamage($dat);
    }
    
    public function __toString(){
        return $this->getDamage() . ($this->isActivated()?" Activated":"") . ($this->isObjectTriggering()?" Triggered":"");
    }
    
    public function onEntityCollide(Entity $entity){
    	$this->setActivated(true);
		$this->getLevel()->scheduleUpdate($this, 0);
		if($this->getSide(Vector3::SIDE_EAST) instanceof Tripwire) $this->getLevel()->scheduleUpdate($this->getSide(Vector3::SIDE_EAST), 0);
		if($this->getSide(Vector3::SIDE_NORTH) instanceof Tripwire) $this->getLevel()->scheduleUpdate($this->getSide(Vector3::SIDE_NORTH), 0);
		if($this->getSide(Vector3::SIDE_SOUTH) instanceof Tripwire) $this->getLevel()->scheduleUpdate($this->getSide(Vector3::SIDE_SOUTH), 0);
		if($this->getSide(Vector3::SIDE_WEST) instanceof Tripwire) $this->getLevel()->scheduleUpdate($this->getSide(Vector3::SIDE_WEST), 0);
    }
	
	public function isEntityCollided(){
		foreach ($this->getLevel()->getChunk($itementity->x >> 4, $itementity->z >> 4)->getEntities() as $entity){
			if($this->getLevel()->getBlock($entity->getPosition()) === $this)
				return true;
		}
		return false;
	}
}