<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\level\sound\ButtonClickSound;
use pocketmine\level\sound\ButtonReturnSound;
use pocketmine\Player;

class WoodenButton extends Flowable implements Redstone, RedstoneSource, RedstoneSwitch{
	
	protected $id = self::WOODEN_BUTTON;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getPower(){
		if($this->meta > 7){
			return Block::REDSTONESOURCEPOWER;
		}
		return 0;
		
	}
	
	public function chkTarget($hash){
		if($this->meta <= 7){
			return false;
		}
		$pb = $this->meta ^ 0x08;
		if($pb%2==0){
			$pb++;
		}else{
			$pb--;
		}
		if($this->getSide($pb)->getHash() == $hash){
			return true;
		}
		return false;
	}
	
	public function canBeActivated(){
		return true;
	}
	
	public function getName(){
		return "Wooden Button";
	}

	public function getHardness(){
		return 0.5;
	}
	
	public function BroadcastRedstoneUpdate($type,$power){
		for($side = 0; $side <= 5; $side++){
			$around=$this->getSide($side);
			$this->getLevel()->setRedstoneUpdate($around,Block::REDSTONEDELAY,$type,$power);
		}
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_SCHEDULED){
			$this->togglePowered();
			$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_BREAK,16);
			return;
		}elseif($type === Level::BLOCK_UPDATE_NORMAL){
			if($this->meta > 7){
				$pb = $this->meta ^ 0x08;
			}else{
				$pb = $this->meta;
			}
			if($pb%2==0){
				$pb++;
			}else{
				$pb--;
			}
			if($this->getSide($pb)->isTransparent() === true){
				$this->getLevel()->useBreakOn($this);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		return;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		if($target->isTransparent() === false){
			$this->meta=$face;
			$this->getLevel()->setBlock($block, $this, true, false);
			return true;
		}
		
		return false;
	}

	public function onActivate(Item $item, Player $player = null){
		if($this->getPower()>0){
			return;
		}
		if(($player instanceof Player && !$player->isSneaking())||$player===null){
			$this->togglePowered();
			$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_PLACE,Block::REDSTONESOURCEPOWER);
			$this->getLevel()->scheduleUpdate($this, 15);
		}
	}

	public function getDrops(Item $item){
		return [[$this->id,0,1]];
	}

	public function isPowered(){
		return (($this->meta & 0x08) === 0x08);
	}

	public function togglePowered(){
		$this->meta ^= 0x08;
		if($this->isPowered()){
			$this->getLevel()->addSound(new ButtonClickSound($this));

		}else{
			$this->getLevel()->addSound(new ButtonReturnSound($this, 1000));
		}
		$this->getLevel()->setBlock($this, $this, true , false);
	}
	
	public function __toString(){
		return $this->getName() . " " . ($this->isPowered()?"":"NOT ") . "POWERED";
	}

}