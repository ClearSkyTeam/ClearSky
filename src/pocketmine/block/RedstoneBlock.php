<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\level\Level;
use pocketmine\Player;

class RedstoneBlock extends Solid implements Redstone,RedstoneSource{

	protected $id = self::REDSTONE_BLOCK;

	public function __construct(){

	}
	
	public function isRedstoneSource(){
		return true;
	}
	
	public function getHardness(){
		return 5;
	}
	
	public function getPower(){
		return Block::REDSTONESOURCEPOWER;
	}
	
	public function isCharged($hash){
		return true;
	}
	
	public function BroadcastRedstoneUpdate($type,$power){
		for($side = 0; $side <= 5; $side++){
			$around=$this->getSide($side);
			$this->getLevel()->setRedstoneUpdate($around,Block::REDSTONEDELAY,$type,$power);
		}
	}
	
	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		return $this->getLevel()->setBlock($this, $this, true, true);
	}
	
	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName(){
		return "Redstone Block";
	}
	
	public function onBreak(Item $item){
		return $this->getLevel()->setBlock($this, new Air(), true, true);
	}
	
	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[Item::REDSTONE_BLOCK, 0, 1],
			];
		}else{
			return [];
		}
	}
}