<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\Player;
use pocketmine\tile\Piston as PistonTile;
use pocketmine\tile\Tile;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\FloatTag;

class Piston extends Solid implements RedstoneConsumer{

	protected $id = self::PISTON;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Piston";
	}

	public function canBeActivated(){
		return true;
	}

	public function getHardness(){
		return 3.5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		if($player instanceof Player){
			$pitch = $player->getPitch();
			if(abs($pitch) >= 45){
				if($pitch < 0) $f = 0;
				else $f = 1;
			}
			else
				$f = $player->getDirection() + 2;
		}
		else
			$f = 0;
		$faces = [0 => 0, 1 => 1, 2 => 5, 3 => 3, 4 => 4, 5 => 2];
		$this->meta = $faces[$f];
		$this->getLevel()->setBlock($block, $this, true, true);
		$nbt = new CompoundTag("", [
			new StringTag("id", Tile::PISTON),
			new IntTag("x", $this->x),
			new IntTag("y", $this->y),
			new IntTag("z", $this->z),
			new IntTag("blockData", 0),
			new IntTag("blockId", 0),
			new ByteTag("extending", 0),
			new IntTag("facing", $faces[$f]),
			new FloatTag("progress", 0.0),
		]);

		$tile = Tile::createTile("Piston", $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);

		return true;
	}

	public function activate(){
		$tile = $this->getLevel()->getTile($this);
		if($tile instanceof PistonTile){
			$tile->activate();
		}
	}
}