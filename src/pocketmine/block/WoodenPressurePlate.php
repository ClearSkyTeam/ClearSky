<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\level\sound\ButtonClickSound;
use pocketmine\level\sound\ButtonReturnSound;
use pocketmine\Player;
use pocketmine\math\Vector3;
use pocketmine\entity\Entity;
use pocketmine\item\Tool;

class WoodenPressurePlate extends Transparent implements Redstone, RedstoneSource, RedstoneSwitch{
	protected $id = self::WOODEN_PRESSURE_PLATE;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function hasEntityCollision(){
		return true;
	}

	public function isRedstoneSource(){
		if($this->meta == 1){
			return true;
		}
		return false;
	}

	public function chkTarget($hash){
		if($hash == $this->getSide(0)->getHash()){
			return true;
		}
		return false;
	}

	public function getToolType(){
		return Tool::TYPE_AXE;
	}

	public function isCharged($hash){
		if($this->meta == 1){
			return true;
		}
		return false;
	}

	public function getName(){
		return "Wooden Pressure Plate";
	}

	public function getHardness(){
		return 0.5;
	}

	public function getPower(){
		if($this->meta == 1){
			return Block::REDSTONESOURCEPOWER;
		}
		else{
			return 0;
		}
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_SCHEDULED){
			if($this->meta == 1){
				if(!$this->isEntityCollided()){
					$this->togglePowered();
				}
				else{
					$this->getLevel()->scheduleUpdate($this, 50);
				}
			}
		}
		elseif($type === Level::BLOCK_UPDATE_NORMAL){
			$down = $this->getSide(0);
			if($down->isTransparent() && !$down instanceof Fence && !($down instanceof Slab && ($down->meta & 0x08) === 0x08) || ($down instanceof WoodSlab && ($down->meta & 0x08) === 0x08) || ($down instanceof Stair && ($down->meta & 0x04) === 0x04)){
				$this->getLevel()->useBreakOn($this);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}

	public function onEntityCollide(Entity $entity){
		if($this->meta == 0){
			$this->togglePowered();
		}
		$this->getLevel()->scheduleUpdate($this, 50);
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $block->getSide(Vector3::SIDE_DOWN);
		if(!$down->isTransparent() || $down instanceof Fence || ($down instanceof Slab && ($down->meta & 0x08) === 0x08) || ($down instanceof WoodSlab && ($down->meta & 0x08) === 0x08) || ($down instanceof Stair && ($down->meta & 0x04) === 0x04)){
			$this->getLevel()->setBlock($block, $this, true, true);
			return true;
		}
		
		return false;
	}

	public function getDrops(Item $item){
		return [[$this->id,0,1]];
	}

	public function isEntityCollided(){
		foreach($this->getLevel()->getChunk($this->x >> 4, $this->z >> 4)->getEntities() as $entity){
			$pos = $entity->getPosition();
			if(abs($this->x - $pos->x) < 1.5 and abs($this->y - $pos->y) < 1.5 and abs($this->z - $pos->z) < 1.5){
				return true;
			}
		}
		return false;
	}

	/**
	 * Toggles the current state of this plate
	 */
	public function togglePowered(){
		$this->meta ^= 0x01;
		if($this->meta == 1){
			$this->getLevel()->addSound(new ButtonClickSound($this));
			$type = Level::REDSTONE_UPDATE_PLACE;
		}
		else{
			$this->getLevel()->addSound(new ButtonReturnSound($this));
			$type = Level::REDSTONE_UPDATE_BREAK;
		}
		$this->getLevel()->setBlock($this, $this, true, false);
		$this->BroadcastRedstoneUpdate($type, Block::REDSTONESOURCEPOWER);
	}
}