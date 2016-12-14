<?php
namespace pocketmine\block;

use pocketmine\block\Block;
use pocketmine\block\Solid;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\tile\Tile;
use pocketmine\math\Vector3;

class Beacon extends Solid{

	protected $id = self::BEACON;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function canBeActivated(){
		return false;
	}

	public function getName(){
		return "Beacon";
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$this->getLevel()->setBlock($this, $this, true, true);
		$nbt = new CompoundTag("", [
			new StringTag("id", Tile::BEACON),
			new IntTag("x", $block->x),
			new IntTag("y", $block->y),
			new IntTag("z", $block->z)
		]);
		$pot = Tile::createTile(Tile::BEACON, $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);
		return true;
	}
}