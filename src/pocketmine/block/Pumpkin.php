<?php
namespace pocketmine\block;

use pocketmine\entity\IronGolem;
use pocketmine\entity\SnowGolem;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Double;
use pocketmine\nbt\tag\Enum;
use pocketmine\nbt\tag\Float;
use pocketmine\Player;

class Pumpkin extends Solid{

	protected $id = self::PUMPKIN;

	public function __construct(){

	}

	public function getHardness(){
		return 1;
	}

	public function getToolType(){
		return Tool::TYPE_AXE;
	}

	public function getName(){
		return "Pumpkin";
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		if($player instanceof Player){
			$this->meta = ((int) $player->getDirection() + 5) % 4;
		}
		$this->getLevel()->setBlock($block, $this, true, true);

		if($player != null){
			$firstBlock = $this->getLevel()->getBlock($block->add(0, -1, 0));
			$secondBlock = $this->getLevel()->getBlock($block->add(0, -2, 0));
			$thirdBlock = $this->getLevel()->getBlock($block->add(-1, -1, 0));
			$fourthBlock = $this->getLevel()->getBlock($block->add(1, -1, 0));
			$fifthBlock = $this->getLevel()->getBlock($block->add(0, -1, -1));
			$sixthBlock = $this->getLevel()->getBlock($block->add(0, -2, 1));

			if($firstBlock->getId() === Item::SNOW_BLOCK && $secondBlock->getId() === Item::SNOW_BLOCK){ //Block match snowgolem
				$this->getLevel()->setBlock($block, new Air());
				$this->getLevel()->setBlock($firstBlock, new Air());
				$this->getLevel()->setBlock($secondBlock, new Air());

				$snowGolem = new SnowGolem($player->getLevel()->getChunk($this->getX() >> 4, $this->getZ() >> 4), new Compound("", [
					"Pos" => new Enum("Pos", [
						new Double("", $this->x),
						new Double("", $this->y),
						new Double("", $this->z)
					]),
					"Motion" => new Enum("Motion", [
						new Double("", 0),
						new Double("", 0),
						new Double("", 0)
					]),
					"Rotation" => new Enum("Rotation", [
						new Float("", 0),
						new Float("", 0)
					]),
				]));
				$snowGolem->spawnToAll();


			}elseif($firstBlock->getId() === Item::IRON_BLOCK && $secondBlock->getId() === Item::IRON_BLOCK){
				if($thirdBlock->getId() === Item::IRON_BLOCK && $fourthBlock->getId() === Item::IRON_BLOCK && $fifthBlock->getId() === Item::AIR && $sixthBlock->getId() === Item::AIR){
					$this->getLevel()->setBlock($thirdBlock, new Air());
					$this->getLevel()->setBlock($fourthBlock, new Air());

				}elseif($fifthBlock->getId() === Item::IRON_BLOCK && $sixthBlock->getId() === Item::IRON_BLOCK && $thirdBlock->getId() === Item::AIR && $fourthBlock->getId() === Item::AIR){
					$this->getLevel()->setBlock($fifthBlock, new Air());
					$this->getLevel()->setBlock($sixthBlock, new Air());

				}else{
					return true;

				}

				$this->getLevel()->setBlock($block, new Air());
				$this->getLevel()->setBlock($firstBlock, new Air());
				$this->getLevel()->setBlock($secondBlock, new Air());

				$ironGolem = new IronGolem($player->getLevel()->getChunk($this->getX() >> 4, $this->getZ() >> 4), new Compound("", [
					"Pos" => new Enum("Pos", [
						new Double("", $this->x),
						new Double("", $this->y),
						new Double("", $this->z)
					]),
					"Motion" => new Enum("Motion", [
						new Double("", 0),
						new Double("", 0),
						new Double("", 0)
					]),
					"Rotation" => new Enum("Rotation", [
						new Float("", 0),
						new Float("", 0)
					]),
				]));
				$ironGolem->spawnToAll();

			}
		}
		return true;
	}

}