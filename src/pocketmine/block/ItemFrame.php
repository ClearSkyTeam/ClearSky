<?php
namespace pocketmine\block;
use pocketmine\block\Block;
use pocketmine\block\Transparent;
use pocketmine\item\Item;
use pocketmine\nbt\NBT;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\tile\Tile;
use pocketmine\Player;

class ItemFrame extends Transparent {
	protected $id = self::ITEM_FRAME_BLOCK;
	
	public function __construct($meta = 0){
		$this->meta = $meta;
	}
	
	public function getHardness(){
		return 0.1;
	}
	
	public function isSolid(){
		return false;
	}
	
	public function canBeActivated(){
		return true;
	}
	
	public function getName(){
		return "Item Frame";
	}
	
	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		if($face > 1){
			$faces = [
				2 => 3,
				3 => 2,
				4 => 1,
				5 => 4,
			];
			$itemTag = NBT::putItemHelper(Item::get(Item::AIR));
			$itemTag->setName("Item");
			$nbt = new CompoundTag("", [
				new StringTag("id", Tile::ITEM_FRAME),
				new IntTag("x", $block->x),
				new IntTag("y", $block->y),
				new IntTag("z", $block->z),
				new CompoundTag("Item", $itemTag->getValue()),
				new FloatTag("ItemDropChance", 1.0),
				new ByteTag("ItemRotation", 0)
			]);
		
			if($item->hasCustomBlockData()){
				foreach($item->getCustomBlockData() as $key => $v){
					$nbt->{$key} = $v;
				}
			}
		
			Tile::createTile("ItemFrame", $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);
			$this->getLevel()->setBlock($block, Block::get(self::ITEM_FRAME_BLOCK, $faces[$face]), true, true);
			return true;
		}
		return false;
	}
	
	public function onActivate(Item $item, Player $player = null){
		$tile = $this->level->getTile($this);
		if($tile instanceof ItemFrame){
			if($tile->getItem()->getId() === Item::AIR){
				$tile->setItem(Item::get($item->getId(), $item->getDamage(), 1));
				$item->setCount($item->getCount() - 1);
			}else{
				$rot = $tile->getItemRotation() + 1;
				$tile->setItemRotation($rot > 8 ? 0:$rot);
			}
			return true;
		}
		return false;
	}
	
	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			$faces = [
				1 => Vector3::SIDE_EAST,
				2 => Vector3::SIDE_NORTH,
				3 => Vector3::SIDE_SOUTH,
				4 => Vector3::SIDE_WEST
			];
			if($this->getSide(isset($faces[$this->meta])?$faces[$this->meta]:-1)->getId() === Item::AIR){
				$this->getLevel()->useBreakOn($this);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
	
	public function getDrops(Item $item){
		return [[Item::ITEM_FRAME, 0, 1]];
	}
}