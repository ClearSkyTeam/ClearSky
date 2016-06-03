<?php
namespace pocketmine\block;

use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\Player;
use pocketmine\utils\Random;
use pocketmine\item\FlintSteel;

class TNT extends Solid implements Redstone, RedstoneConsumer{

	protected $id = self::TNT;

	public function __construct(){

	}

	public function getName(){
		return "TNT";
	}

	public function getHardness(){
		return 0;
	}

	public function canBeActivated(){
		return true;
	}

	public function onActivate(Item $item, Player $player = null){
		if($item->getId() === Item::FLINT_STEEL){
			$item->useOn($this);
			$this->getLevel()->setBlock($this, new Air(), true);

			$mot = (new Random())->nextSignedFloat() * M_PI * 2;
			$tnt = Entity::createEntity("PrimedTNT", $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), new CompoundTag("", [
				"Pos" => new ListTag("Pos", [
					new DoubleTag("", $this->x + 0.5),
					new DoubleTag("", $this->y),
					new DoubleTag("", $this->z + 0.5)
				]),
				"Motion" => new ListTag("Motion", [
					new DoubleTag("", -sin($mot) * 0.02),
					new DoubleTag("", 0.2),
					new DoubleTag("", -cos($mot) * 0.02)
				]),
				"Rotation" => new ListTag("Rotation", [
					new FloatTag("", 0),
					new FloatTag("", 0)
				]),
				"Fuse" => new ByteTag("Fuse", 80)
			]));

			$tnt->spawnToAll();

			return true;
		}

		return false;
	}

	public function onRedstoneUpdate($type,$power){
		if($this->isPowered()){
			$this->onActivate(new FlintSteel());
			return;
		}
	}
}