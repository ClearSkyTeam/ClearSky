<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\level\sound\ButtonClickSound;
use pocketmine\level\sound\ButtonReturnSound;
use pocketmine\Player;

class Lever extends Flowable implements Redstone,RedstoneSource,RedstoneSwitch{

	protected $id = self::LEVER;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Lever";
	}

	public function isRedstone(){
		return true;
	}
	
	public function canBeActivated(){
		return true;
	}
	
	public function getPower(){
		if($this->meta < 7){
			return 0;
		}
		return Block::REDSTONESOURCEPOWER;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			if($this->meta <= 7){
				$pb = $this->meta;
			}else{
				$pb = $this->meta ^ 0x08;
			}
			$faces = [
				4=>3,
				2=>5,
				3=>2,
				1=>4,
				0=>1,
				7=>1,
				6=>0,
				5=>0,
			];
			if($this->getSide($faces[$pb])->isTransparent() === true){
				$this->getLevel()->useBreakOn($this);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		return true;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){

		if($target->isTransparent() === false){
			$faces = [
				3 => 3,
				2 => 4,
				4 => 2,
				5 => 1,
			];
			if($face === 0){
				$to = $player instanceof Player?$player->getDirection():0;
				$this->meta = ($to ^ 0x01 === 0x01?0:7);
			}
			elseif($face === 1){
				$to = $player instanceof Player?$player->getDirection():0;
				$this->meta = ($to ^ 0x01 === 0x01?6:5);
			}
			else{
				$this->meta = $faces[$face];
			}
			$this->getLevel()->setBlock($block, $this, true, true);

			return true;
		}

		return false;
	}
	
	public function isRedstoneSource(){
		if($this->meta <= 7 ){
			return false;
		}
		return true;
	}
	
	public function chkTarget($hash){
		if($this->meta <= 7){
			return false;
		}
		$pb = $this->meta ^ 0x08;
		$faces = [
			4=>3,
			2=>5,
			3=>2,
			1=>4,
			0=>1,
			7=>1,
			6=>0,
			5=>0,
		];
		if($this->getSide($faces[$pb])->getHash() == $hash){
			return true;
		}
		return false;
	}
	
	public function BroadcastRedstoneUpdate($type,$power){
		for($side = 0; $side <= 5; $side++){
			$around=$this->getSide($side);
			$this->getLevel()->setRedstoneUpdate($around,Block::REDSTONEDELAY,$type,$power);
		}
	}
	
	public function onActivate(Item $item, Player $player = null){
		if($this->meta <= 7 ){
			$this->getLevel()->addSound(new ButtonClickSound($this));
			$type = Level::REDSTONE_UPDATE_PLACE;
		}else{
			$this->getLevel()->addSound(new ButtonReturnSound($this));
			$type = Level::REDSTONE_UPDATE_BREAK;
		}
		$this->meta ^= 0x08;
		$this->getLevel()->setBlock($this, $this ,true ,false);
		$this->BroadcastRedstoneUpdate($type,Block::REDSTONESOURCEPOWER);
		return true;
	}
	
	public function getDrops(Item $item){
		return [[$this->id,0,1]];
	}
	
}
