<?php
namespace pocketmine\block;

use pocketmine\inventory\EnchantInventory;
use pocketmine\item\Item;
use pocketmine\item\Tool;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\Player;
use pocketmine\tile\Tile;
use pocketmine\nbt\tag\ListTag;
use pocketmine\tile\EnchantTable;
use pocketmine\math\AxisAlignedBB;

class EnchantingTable extends Transparent{

	protected $id = self::ENCHANTING_TABLE;

	public function __construct(){

	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$this->getLevel()->setBlock($block, $this, true, true);
		$nbt = new CompoundTag("", [
			new StringTag("id", Tile::ENCHANT_TABLE),
			new IntTag("x", $this->x),
			new IntTag("y", $this->y),
			new IntTag("z", $this->z)
		]);

		if($item->hasCustomName()){
			$nbt->CustomName = new StringTag("CustomName", $item->getCustomName());
		}

		if($item->hasCustomBlockData()){
			foreach($item->getCustomBlockData() as $key => $v){
				$nbt->{$key} = $v;
			}
		}

		Tile::createTile(Tile::ENCHANT_TABLE, $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);

		return true;
	}

	public function canBeActivated(){
		return true;
	}

	public function getHardness(){
		return 5;
	}

	public function getResistance(){
		return 6000;
	}

	public function getName(){
		return "Enchanting Table";
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function onActivate(Item $item, Player $player = null){
		if($player instanceof Player){

			$t = $this->getLevel()->getTile($this);
			$table = null;
			if($t instanceof EnchantTable){
				$table = $t;
			}else{
				$nbt = new CompoundTag("", [
					new ListTag("Items", []),
					new StringTag("id", Tile::ENCHANT_TABLE),
					new IntTag("x", $this->x),
					new IntTag("y", $this->y),
					new IntTag("z", $this->z)
				]);
				$nbt->Items->setTagType(NBT::TAG_Compound);
				$table = Tile::createTile("EnchantTable", $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);
			}

			if(isset($table->namedtag->Lock) and $table->namedtag->Lock instanceof StringTag){
				if($table->namedtag->Lock->getValue() !== $item->getCustomName()){
					return true;
				}
			}
			$player->addWindow($table->getInventory());
		}

		return true;
	}

	public function getDrops(Item $item){
		if($item->isPickaxe() >= Tool::TIER_WOODEN){
			return [
				[$this->id, 0, 1],
			];
		}else{
			return [];
		}
	}

	protected function recalculateBoundingBox(){
		return new AxisAlignedBB(
			$this->x,
			$this->y,
			$this->z,
			$this->x + 0.9375,
			$this->y + 0.75,
			$this->z + 0.9375
		);
	}
}