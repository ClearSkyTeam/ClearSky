<?php
namespace pocketmine\block;

use pocketmine\item\Tool;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;

class RedstoneLamp extends Solid implements Redstone,RedstoneConsumer,LightSource{

	protected $id = self::REDSTONE_LAMP;

	public function __construct(){

	}
	
	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getLightLevel(){
		return 0;
	}
	
	public function isLightSource(){
		return false;
	}

	public function getName(){
		return "Redstone Lamp";
	}

	public function getHardness(){
		return 0.3;
	}
}
