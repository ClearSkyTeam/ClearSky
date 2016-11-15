<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\math\Vector3;

class RedstoneWire extends Flowable implements Redstone, RedstoneTransmitter{
	protected $id = self::REDSTONE_WIRE;

	public function isRedstone(){
		return true;
	}

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getPower(){
		$this_hash = Level::blockHash($this->x, $this->y, $this->z);
		if(isset($this->getLevel()->RedstoneUpdateList[$this_hash])){
			return $this->getLevel()->RedstoneUpdateList[$this_hash]['power'];
		}
		else{
			return $this->meta;
		}
	}

	public function getmetaPower(){
		return $this->meta;
	}

	public function getcatchPower(){
		$this_hash = Level::blockHash($this->x, $this->y, $this->z);
		if(isset($this->getLevel()->RedstoneUpdateList[$this_hash])){
			return $this->getLevel()->RedstoneUpdateList[$this_hash]['power'];
		}
		else{
			return null;
		}
	}

	public function setPower($power){
		$this->meta = $power;
		$this->getLevel()->setBlock($this, $this, true, false);
	}

	public function getHardness(){
		return 0;
	}

	public function isSolid(){
		return true;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			$down = $this->getSide(0);
			if($down->isTransparent() && !($down instanceof Slab && ($down->meta & 0x08) === 0x08) || ($down instanceof WoodSlab && ($down->meta & 0x08) === 0x08) || ($down instanceof Stair && ($down->meta & 0x04) === 0x04)){
				$this->getLevel()->useBreakOn($this);
				return Level::BLOCK_UPDATE_NORMAL;
			}
			if($this->getLevel()->getServer()->getProperty("redstone.enable", true)){
				if($this->fetchMaxPower()<$this->getmetaPower()+1){
					$this->setRedstoneUpdateList(Level::REDSTONE_UPDATE_LOSTPOWER,$this->getmetaPower()+1);
				}else{
					$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_PLACE,$this->getmetaPower());
				}
			}
		}
		return true;
	}

	public function fetchMaxPower(){
		$power_in_max = 0;
		for($side = 0; $side <= 5; $side++){
			$near = $this->getSide($side);
			
			if($near->isStrongCharged()){
				return Block::REDSTONESOURCEPOWER;
			}
			
			if($near->isRedstoneSource()){
				$power_in = $near->getPower();
				if($power_in == Block::REDSTONESOURCEPOWER){
					return Block::REDSTONESOURCEPOWER;
				}
				elseif($power_in > $power_in_max){
					return $power_in;
				}
			}
			
			if($side >= 2){
				if($near instanceof RedstoneTransmitter){
					$power_in = $near->getPower();
					if($power_in > $power_in_max){
						$power_in_max = $power_in;
					}
				}
				else{
					$near = $this->getSide($side);
					$around_down = $near->getSide(0);
					$around_up = $near->getSide(1);
					$around_next = $near->getSide($side);
					if($near->getId() == Block::AIR and $around_down instanceof RedstoneTransmitter){
						$power_in = $around_down->getPower();
						if($power_in > $power_in_max){
							$power_in_max = $power_in;
						}
					}
					elseif(!$near instanceof Transparent and $around_up instanceof RedstoneTransmitter and $this->getSide(1) instanceof Transparent){
						$power_in = $around_up->getPower();
						if($power_in > $power_in_max){
							$power_in_max = $power_in;
						}
					}
				}
			}
		}
		return $power_in_max;
	}

	public function getName(){
		return "Redstone Wire";
	}

	public function getDrops(Item $item){
		return [[Item::REDSTONE_DUST,0,1]];
	}

	public function __toString(){
		return $this->getName() . ($this->meta > 0?"":"NOT ") . "POWERED";
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $this->getSide(0);
		if($down->isTransparent() && !($down instanceof Slab && ($down->meta & 0x08) === 0x08) || ($down instanceof WoodSlab && ($down->meta & 0x08) === 0x08) || ($down instanceof Stair && ($down->meta & 0x04) === 0x04)){
			return false;
		}
		else{
			$this->getLevel()->setBlock($block, $this, true, true);
			if($this->getLevel()->getServer()->getProperty("redstone.enable", true)){
				$this->setRedstoneUpdateList(Level::REDSTONE_UPDATE_NORMAL, $this->fetchMaxPower());
				$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_PLACE, $this->getPower());
			}
			return true;
		}
	}

	public function onBreak(Item $item){
		$oBreturn = $this->getLevel()->setBlock($this, new Air(), true, true);
		$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_BREAK, $this->getPower());
		return $oBreturn;
	}

	public function doRedstoneListUpdate(){
		foreach($this->getLevel()->RedstoneUpdaters as $Updaters){
			if($Updaters){
				unset($Updaters);
			}
			else{
				return;
			}
		}
		
		foreach($this->getLevel()->RedstoneRepowers as $repower){
			$this->getLevel()->setRedstoneUpdate($this, Block::REDSTONEDELAY, Level::REDSTONE_UPDATE_REPOWER, 0);
			return;
		}
		
		$this->getLevel()->RedstoneUpdaters = [];
		foreach($this->getLevel()->RedstoneUpdateList as $tblock){
			$hash = Level::blockHash($tblock['x'], $tblock['y'], $tblock['z']);
			$pos = new Vector3($tblock['x'], $tblock['y'], $tblock['z']);
			$target = $this->getLevel()->getBlock($pos);
			$setpower = $tblock['power'];
			$originalpower = $target->getmetaPower();
			$target->setPower($setpower);
			unset($this->getLevel()->RedstoneUpdateList[$hash]);
			$target->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_NORMAL, $setpower);
		}
	}

	public function setRedstoneUpdateList($type, $power){
		if($type === Level::REDSTONE_UPDATE_NORMAL){
			if($power > $this->getPower() + 1){
				$this_hash = Level::blockHash($this->x, $this->y, $this->z);
				$this->getLevel()->RedstoneUpdaters[$this_hash] = false;
				$thispower = $power - 1;
				$this->getLevel()->RedstoneUpdateList[$this_hash] = ['x' => $this->x,'y' => $this->y,'z' => $this->z,'power' => $thispower];
				
				for($side = 2; $side <= 5; $side++){
					$near = $this->getSide($side);
					if($near instanceof RedstoneTransmitter){
						$near->setRedstoneUpdateList($type, $thispower);
					}
					else{
						$around_down = $near->getSide(0);
						$around_up = $near->getSide(1);
						if($near->getId() == Block::AIR and $around_down instanceof RedstoneTransmitter){
							$around_down->setRedstoneUpdateList($type, $thispower);
						}
						elseif(!$near instanceof Transparent and $around_up instanceof RedstoneTransmitter and $this->getSide(1) instanceof Transparent){
							$around_up->setRedstoneUpdateList($type, $thispower);
						}
					}
				}
				$this->getLevel()->RedstoneUpdaters[$this_hash] = true;
				$this->doRedstoneListUpdate();
			}
			else{
				return;
			}
		}
		
		if($type === Level::REDSTONE_UPDATE_REPOWER){
			$type = Level::REDSTONE_UPDATE_NORMAL;
			$this_hash = Level::blockHash($this->x, $this->y, $this->z);
			unset($this->getLevel()->RedstoneRepowers[$this_hash]);
			$thispower = $this->getPower();
			$this->getLevel()->RedstoneUpdateList[$this_hash] = ['x' => $this->x,'y' => $this->y,'z' => $this->z,'power' => $thispower];
			
			for($side = 2; $side <= 5; $side++){
				$near = $this->getSide($side);
				if($near instanceof RedstoneTransmitter){
					$near->setRedstoneUpdateList($type, $thispower);
				}
				else{
					$around_down = $near->getSide(0);
					$around_up = $near->getSide(1);
					if($near->getId() == Block::AIR and $around_down instanceof RedstoneTransmitter){
						$around_down->setRedstoneUpdateList($type, $thispower);
					}
					elseif(!$near instanceof Transparent and $around_up instanceof RedstoneTransmitter and $this->getSide(1) instanceof Transparent){
						$around_up->setRedstoneUpdateList($type, $thispower);
					}
				}
			}
			$this->doRedstoneListUpdate();
		}
		
		if($type === Level::REDSTONE_UPDATE_LOSTPOWER){
			if($this->getPower() !== 0 and $power >= $this->getPower + 1){
				$thispower = $this->getPower();
				$this_hash = Level::blockHash($this->x, $this->y, $this->z);
				$this->getLevel()->RedstoneUpdateList[$this_hash] = ['x' => $this->x,'y' => $this->y,'z' => $this->z,'power' => 0];
				$FetchedMaxPower = $this->fetchMaxPower();
				if($FetchedMaxPower == Block::REDSTONESOURCEPOWER){
					unset($this->getLevel()->RedstoneUpdateList[$this_hash]);
					$this->getLevel()->RedstoneRepowers[$this_hash] = ['x' => $this->x,'y' => $this->y,'z' => $this->z];
					return;
				}
				
				$this->getLevel()->RedstoneUpdaters[$this_hash] = false;
				for($side = 2; $side <= 5; $side++){
					$near = $this->getSide($side);
					if($near instanceof RedstoneTransmitter){
						$near_hash = Level::blockHash($near->x, $near->y, $near->z);
						if(isset($this->getLevel()->RedstoneUpdateList[$near_hash])){
							continue;
						}
						$near->setRedstoneUpdateList($type, $thispower);
					}
					else{
						$around_down = $near->getSide(0);
						$around_up = $near->getSide(1);
						if($near->getId() == Block::AIR and $around_down instanceof RedstoneTransmitter){
							$around_down_hash = Level::blockHash($around_down->x, $around_down->y, $around_down->z);
							if(isset($this->getLevel()->RedstoneUpdateList[$around_down_hash])){
								continue;
							}
							$around_down->setRedstoneUpdateList($type, $thispower);
						}
						elseif(!$near instanceof Transparent and $around_up instanceof RedstoneTransmitter and $this->getSide(1) instanceof Transparent){
							$around_up_hash = Level::blockHash($around_up->x, $around_up->y, $around_up->z);
							if(isset($this->getLevel()->RedstoneUpdateList[$around_up_hash])){
								continue;
							}
							$around_up->setRedstoneUpdateList($type, $thispower);
						}
					}
				}
				$this->getLevel()->RedstoneUpdaters[$this_hash] = true;
				$this->doRedstoneListUpdate();
			}
		}
	}

	public function BroadcastRedstoneUpdate($type, $power){
		$down = $this->getSide(0);
		for($side = 0; $side <= 5; $side++){
			$around = $this->getSide($side);
			$this->getLevel()->setRedstoneUpdate($around, Block::REDSTONEDELAY, $type, $power);
			if($type === Level::REDSTONE_UPDATE_BREAK){
				$up = $around->getSide(1);
				$down = $around->getSide(0);
				if(!$around instanceof Transparent and $up instanceof RedstoneTransmitter and $this->getSide(1) instanceof Transparent){
					$this->getLevel()->setRedstoneUpdate($up, Block::REDSTONEDELAY, $type, $power);
				}
				elseif($around->id == self::AIR and $down instanceof Redstone){
					$this->getLevel()->setRedstoneUpdate($down, Block::REDSTONEDELAY, $type, $power);
				}
			}
		}
	}

	public function onRedstoneUpdate($type, $power){
		if($type == Level::REDSTONE_UPDATE_PLACE){
			$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_NORMAL, $this->getPower());
			if($power > $this->getPower() + 1){
				$this->setRedstoneUpdateList(Level::REDSTONE_UPDATE_NORMAL, $power);
			}
			return;
		}
		
		if($type == Level::REDSTONE_UPDATE_REPOWER){
			foreach($this->getLevel()->RedstoneRepowers as $repower){
				$pos = new Vector3($repower['x'], $repower['y'], $repower['z']);
				$this->getLevel()->getBlock($pos)->setRedstoneUpdateList(Level::REDSTONE_UPDATE_REPOWER, null);
				return;
			}
		}
		
		if($type == Level::REDSTONE_UPDATE_BLOCK){
			$mP = $this->fetchMaxPower();
			if($mP > $this->getPower() + 1){
				$this->setRedstoneUpdateList(Level::REDSTONE_UPDATE_NORMAL, $power);
				return;
			}
			if($mP == $this->getPower() + 1){
				return;
			}
			if($mP < $this->getPower() + 1){
				$this->setRedstoneUpdateList(Level::REDSTONE_UPDATE_LOSTPOWER, $power);
				return;
			}
		}
		
		if($type == Level::REDSTONE_UPDATE_BREAK){
			if($power > $this->getPower()){
				$this->setRedstoneUpdateList(Level::REDSTONE_UPDATE_LOSTPOWER, $power);
			}
			$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_NORMAL, $this->getPower());
			return;
		}
	}
}