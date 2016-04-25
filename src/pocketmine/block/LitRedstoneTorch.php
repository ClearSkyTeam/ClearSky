<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\level\Circut;
use pocketmine\Player;
use pocketmine\math\Vector3;

class LitRedstoneTorch extends Flowable implements Redstone, RedstoneSource, LightSource{
	protected $id = self::LIT_REDSTONE_TORCH;
	protected $circut;
	

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getLightLevel(){
		return 7;
	}
	
	public function isLightSource(){
		return true;
	}

	public function isRedstoneSource(){
		return true;
	}

	public function isCharged($hash){
		$side = $this->getDamage();
		$faces = [1 => 4,2 => 5,3 => 2,4 => 3,5 => 0,6 => 0,0 => 0];
		if($this->getSide($faces[$side])->getHash() == $hash){
			return false;
		}
		return true;
	}

	public function getName(){
		return "Redstone Torch";
	}

	public function getPower(){
		return 16;
	}
	
	public function setPower($power){
		return true;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			$below = $this->getSide(0);
			$side = $this->getDamage();
			$faces = [1 => 4,2 => 5,3 => 2,4 => 3,5 => 0,6 => 0,0 => 0];
			
			if($this->getSide($faces[$side])->isTransparent() === true and !($side === 0 and ($below instanceof Fence or $below->getId() === self::COBBLE_WALL or $below->getId() === self::GLASS || ($below instanceof Slab && ($below->meta & 0x08) === 0x08) || ($below instanceof WoodSlab && ($below->meta & 0x08) === 0x08) || ($below instanceof Stair && ($below->meta & 0x04) === 0x04)))){
				$this->getLevel()->useBreakOn($this);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $this->getSide(0);
		if($target->isTransparent() === false and $face !== 0){
			$faces = [1 => 5,2 => 4,3 => 3,4 => 2,5 => 1];
			$this->meta = $faces[$face];
			
			$side = $faces[$face];
			$faces = [1 => 4,2 => 5,3 => 2,4 => 3,5 => 0,6 => 0,0 => 0];
			if($this->getSide($faces[$side])->isCharged($this->getHash())){
				$this->id = 75;
				$this->getLevel()->setBlock($block, $this);
				return;
			}
			$this->getLevel()->setBlock($block, $this);
			$this->circut = new Circut($this);
			return true;
		}
		elseif($down->isTransparent() === false or $down instanceof Fence or $down->getId() === self::COBBLE_WALL or $down->getId() === self::GLASS || ($down instanceof Slab && ($down->meta & 0x08) === 0x08) || ($down instanceof WoodSlab && ($down->meta & 0x08) === 0x08) || ($down instanceof Stair && ($down->meta & 0x04) === 0x04)){
			$this->meta = 0;
			if($target->isCharged($this->getHash())){
				$this->id = 75;
				$this->getLevel()->setBlock($block, $this);
				return;
			}
			$this->getLevel()->setBlock($block, $this);
			return true;
		}
		
		return false;
	}
	
	public function onBreak(Item $item){
		echo"Torch Circut on Break:";
		$circuts = $this->getLevel()->getCircuts($this);
		foreach($circuts as $circut){
			if($circut instanceof Circut){
				$circut->del($this);
			}
		}
		return $this->getLevel()->setBlock($this, new Air(), true, true);
	}

	public function getDrops(Item $item){
		return [[$this->id,0,1]];
	}
}