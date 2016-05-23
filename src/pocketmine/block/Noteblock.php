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
use pocketmine\level\sound\NoteblockSound;
use pocketmine\tile\Music;

class Noteblock extends Solid{

	protected $id = self::NOTEBLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function canBeActivated(){
		return true;
	}

	public function getHardness(){
		return 0.8;
	}
	
	public function getResistance(){
		return 4;
	}

	public function getName(){
		return "Note Block";
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$this->getLevel()->setBlock($this, $this, true, true);
		$nbt = new Compound("", [
			new String("id", Tile::NOTEBLOCK),
			new Int("x", $block->x),
			new Int("y", $block->y),
			new Int("z", $block->z),
			new Byte("note", 0)
		]);
		$pot = Tile::createTile("Music", $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);
		return true;
	}

	public function getInstrument(){
		$downblock = $this->level->getBlock($this->getSide(Vector3::SIDE_DOWN));
		switch($downblock->getId()){
			case Block::WOOD:
			case Block::WOOD2:
			case Block::WOODEN_PLANK:
			case Block::WOODEN_SLABS:
			case Block::DOUBLE_WOOD_SLABS:
			case Block::OAK_WOODEN_STAIRS:
			case Block::SPRUCE_WOODEN_STAIRS:
			case Block::BIRCH_WOODEN_STAIRS:
			case Block::JUNGLE_WOODEN_STAIRS:
			case Block::ACACIA_WOODEN_STAIRS:
			case Block::DARK_OAK_WOODEN_STAIRS:
			case Block::FENCE:
			case Block::FENCE_GATE:
			case Block::FENCE_GATE_SPRUCE:
			case Block::FENCE_GATE_BIRCH:
			case Block::FENCE_GATE_JUNGLE:
			case Block::FENCE_GATE_DARK_OAK:
			case Block::FENCE_GATE_ACACIA:
			case Block::SPRUCE_WOOD_STAIRS:
			case Block::BOOKSHELF:
			case Block::CHEST:
			case Block::CRAFTING_TABLE:
			case Block::SIGN_POST:
			case Block::WALL_SIGN:
			case Block::DOOR_BLOCK:
			case Block::NOTEBLOCK:
				return NoteblockSound::INSTRUMENT_BASEGUITAR;
			case Block::SAND:
				return NoteblockSound::INSTRUMENT_SNARE;
			case Block::GLASS:
			case Block::GLASS_PANE:
				return NoteblockSound::INSTRUMENT_CLICKS;
			case Block::STONE:
			case Block::COBBLESTONE:
			case Block::SANDSTONE:
			case Block::MOSS_STONE:
			case Block::BRICKS:
			case Block::STONE_BRICK:
			case Block::NETHER_BRICKS:
			case Block::QUARTZ_BLOCK:
			case Block::SLAB:
			case Block::COBBLESTONE_STAIRS:
			case Block::BRICK_STAIRS:
			case Block::STONE_BRICK_STAIRS:
			case Block::NETHER_BRICKS_STAIRS:
			case Block::SANDSTONE_STAIRS:
			case Block::QUARTZ_STAIRS:
			case Block::COBBLESTONE_WALL:
			case Block::NETHER_BRICK_FENCE:
			case Block::BEDROCK:
			case Block::GOLD_ORE:
			case Block::IRON_ORE:
			case Block::COAL_ORE:
			case Block::LAPIS_ORE:
			case Block::DIAMOND_ORE:
			case Block::REDSTONE_ORE:
			case Block::GLOWING_REDSTONE_ORE:
			case Block::EMERALD_ORE:
			case Block::FURNACE:
			case Block::BURNING_FURNACE:
			case Block::OBSIDIAN:
			case Block::MONSTER_SPAWNER:
			case Block::NETHERRACK:
			case Block::ENCHANTING_TABLE:
			case Block::END_STONE:
			case Block::STAINED_CLAY:
			case Block::COAL_BLOCK:
				return NoteblockSound::INSTRUMENT_BASEDRUM;
		}
		return NoteblockSound::INSTRUMENT_PIANO;
	}

	public function onActivate(Item $item, Player $player = null){
		$tile = $this->level->getTile($this);
		if($tile instanceof Music){
			$instrument = $this->getInstrument();
			$pitch = $tile->getNote() + 1;
			if($pitch < 0 or $pitch > 24){
				$pitch = 0;
			}
			$tile->setNote($pitch);
			$this->level->addSound(new NoteblockSound($this, $instrument, $pitch));
			return true;
		}
		return false;
	}
}