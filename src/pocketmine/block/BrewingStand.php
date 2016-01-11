<?php
namespace pocketmine\block;

use pocketmine\inventory\BrewingInventory;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Int;
use pocketmine\nbt\tag\String;
use pocketmine\Player;
use pocketmine\tile\Tile;
use pocketmine\tile\BrewingStand as TileBrewingStand;
use pocketmine\math\Vector3;

class BrewingStand extends Transparent{

	protected $id = self::BREWING_STAND_BLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		if($block->getSide(Vector3::SIDE_DOWN)->isTransparent() === false){
			$this->getLevel()->setBlock($block, $this, true, true);
		$nbt = new Compound("", [
			new String("id", Tile::BREWING_STAND),
			new Int("x", $this->x),
			new Int("y", $this->y),
			new Int("z", $this->z)
		]);
			if($item->hasCustomName()){
				$nbt->CustomName = new String("CustomName", $item->getCustomName());
			}
			
			if($item->hasCustomBlockData()){
				foreach($item->getCustomBlockData() as $key => $v){
					$nbt->{$key} = $v;
				}
			}
			
			Tile::createTile(Tile::BREWING_STAND, $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);
			
			return true;
		}
		return false;
	}

	public function canBeActivated(){
		return true;
	}

	public function getHardness(){
		return 3;
	}

	public function getName(){
		return "Brewing Stand";
	}

	public function onActivate(Item $item, Player $player = null){
		if($player instanceof Player){
			//TODO lock
			if($player->isCreative()){
				return true;
			}
			if(($t = $this->getLevel()->getTile($this)) instanceof TileBrewingStand) $player->addWindow(new BrewingInventory($t));
		}

		return true;
	}

	public function getDrops(Item $item){
		$drops = [];
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			$drops[] = [Item::BREWING_STAND, 0, 1];
		}

		return $drops;
	}
}
