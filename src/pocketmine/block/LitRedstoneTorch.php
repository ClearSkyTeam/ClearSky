<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\math\Vector3;

class LitRedstoneTorch extends Flowable implements Redstone,RedstoneSource{

	protected $id = self::LIT_REDSTONE_TORCH;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}
	
	public function getLightLevel(){
		return 7;
	}
	
	public function isRedstoneSource(){
		return true;
	}
	
	public function isCharged($hash){
		$side = $this->getDamage();
		$faces = [
			1 => 4,
			2 => 5,
			3 => 2,
			4 => 3,
			5 => 0,
			6 => 0,
			0 => 0,
		];
		if($this->getSide($faces[$side])->getHash() == $hash){
			return false;
		}
		return true;
	}

	public function getName(){
		return "Redstone Torch";
	}
	
	public function getPower(){
		return Block::REDSTONESOURCEPOWER;
	}
	
	public function BroadcastRedstoneUpdate($type,$power){
		for($side = 1; $side <= 5; $side++){
			$around=$this->getSide($side);
			$this->getLevel()->setRedstoneUpdate($around,Block::REDSTONEDELAY,$type,$power);
		}
	}
	
	public function onRedstoneUpdate($type,$power){
		if($type === Level::REDSTONE_UPDATE_BLOCK){
			$side = $this->getDamage();
			$faces = [
				1 => 4,
				2 => 5,
				3 => 2,
				4 => 3,
				5 => 0,
				6 => 0,
				0 => 0,
			];
			if(!$this->getSide($faces[$side])->isCharged($this->getHash())){
				return;
			}
			$this->id = 75;
			$this->getLevel()->setBlock($this, $this, true, false);
			$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_BREAK,Block::REDSTONESOURCEPOWER);
			return;
		}
		return;
	}
	
	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			$below = $this->getSide(0);
			$side = $this->getDamage();
			$faces = [
					1 => 4,
					2 => 5,
					3 => 2,
					4 => 3,
					5 => 0,
					6 => 0,
					0 => 0
					];
			
			if($this->getSide($faces[$side])->isTransparent() === true and !($side === 0 and ($below->getId() === self::FENCE or $below->getId() === self::COBBLE_WALL))){
				$this->getLevel()->useBreakOn($this);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$below = $this->getSide(0);
		if($target->isTransparent() === false and $face !== 0){
			$faces = [
				1 => 5,
				2 => 4,
				3 => 3,
				4 => 2,
				5 => 1,
			];
			$this->meta = $faces[$face];

			$side = $faces[$face];
			$faces = [
				1 => 4,
				2 => 5,
				3 => 2,
				4 => 3,
				5 => 0,
				6 => 0,
				0 => 0,
			];
			if($this->getSide($faces[$side])->isCharged($this->getHash())){
				$this->id = 75;
				$this->getLevel()->setBlock($block, $this);
				return;
			}
			$this->getLevel()->setBlock($block, $this);
			$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_PLACE, Block::REDSTONESOURCEPOWER);
			
			return true;
		}elseif($below->isTransparent() === false or $below->getId() === self::FENCE or $below->getId() === self::COBBLE_WALL){
			$this->meta = 0;
			if($target->isCharged($this->getHash())){
				$this->id = 75;
				$this->getLevel()->setBlock($block, $this);
				return;
			}
			$this->getLevel()->setBlock($block, $this);
			$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_PLACE, Block::REDSTONESOURCEPOWER);
			return true;
		}

		return false;
	}
	
	public function getDrops(Item $item){
		return [
			[$this->id, 0, 1],
		];
	}
}