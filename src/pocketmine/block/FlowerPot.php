<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\tile\Tile;
use pocketmine\math\AxisAlignedBB;
use pocketmine\nbt\tag\String;
use pocketmine\nbt\tag\Int;
use pocketmine\nbt\tag\Short;
use pocketmine\nbt\tag\Compound;
use pocketmine\tile\FlowerPot as FlowerPotTile;

class FlowerPot extends Flowable{
	protected $id = Block::FLOWER_POT_BLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function canBeActivated(){
		return true;
	}

	public function getHardness(){
		return 0;
	}

	public function getName(){
		return "Flower Pot";
	}

	public function getBoundingBox(){
		return new AxisAlignedBB($this->x - 0.6875, $this->y - 0.375, $this->z - 0.6875, $this->x + 0.6875, $this->y + 0.375, $this->z + 0.6875);
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $block->getSide(0);
		if($down->isTransparent() === false || ($down instanceof Slab && ($down->meta & 0x08) === 0x08) || ($down instanceof WoodSlab && ($down->meta & 0x08) === 0x08) || ($down instanceof Stair && ($down->meta & 0x04) === 0x04)){
			$this->getLevel()->setBlock($block, $this, true, true);
			$nbt = new Compound("", [
				new String("id", Tile::FLOWER_POT),
				new Int("x", $block->x),
				new Int("y", $block->y),
				new Int("z", $block->z),
				new Short("item", 0),
				new Int("mData", 0)
			]);
			$pot = Tile::createTile("FlowerPot", $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);
			return true;
		}
		return false;
	}

	public function onActivate(item $item, Player $player = null){
		$tile = $this->getLevel()->getTile($this);
		if($tile instanceof FlowerPotTile){
			if($tile->getFlowerPotItem() === item::AIR){
				switch($item->getId()){
					case item::TALL_GRASS:
						if($item->getDamage() === 1){
							break;
						}
					case item::SAPLING:
					case item::DEAD_BUSH:
					case item::DANDELION:
					case item::RED_FLOWER:
					case item::BROWN_MUSHROOM:
					case item::RED_MUSHROOM:
					case item::CACTUS:
						$tile->setFlowerPotData($item->getId(), $item->getDamage());
						if($player->isSurvival()){
							$item->count--;
						}
						return true;
						break;
				}
			}
		}
		return false;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			if($this->getSide(Vector3::SIDE_DOWN)->getId() === item::AIR){
				$this->getLevel()->useBreakOn($this);
				return Level::BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}

	public function getDrops(item $item){
		$items = array([item::FLOWER_POT,0,1]);
		if(($tile = $this->getLevel()->getTile($this)) instanceof FlowerPotTile){
			if($tile->getFlowerPotItem() !== item::AIR){
				$items[] = array($tile->getFlowerPotItem(),$tile->getFlowerPotData(),1);
			}
		}
		return $items;
	}
}