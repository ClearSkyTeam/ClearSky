<?php
namespace pocketmine\block;

use pocketmine\item\Tool;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;

class RedstoneLamp extends Solid implements Redstone,RedstoneConsumer{

	protected $id = self::REDSTONE_LAMP;

	public function __construct(){

	}
	
	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}
	
	
	
	public function onRedstoneUpdate($type, $power){
		if($this->isPowered()){
			$this->BroadcastRedstoneUpdate(Level::REDSTONE_UPDATE_BLOCK,$power);
			$this->id = 124;
			$this->getLevel()->setBlock($this, $this);
			return;
		}
	}

	public function getName(){
		return "Redstone Lamp";
	}

	public function getHardness(){
		return 0.3;
	}
}
