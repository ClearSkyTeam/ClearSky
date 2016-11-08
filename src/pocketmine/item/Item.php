<?php
/**
 * All the Item classes
 */
namespace pocketmine\item;

use pocketmine\block\Anvil;
use pocketmine\block\Block;
use pocketmine\block\Fence;
use pocketmine\block\Flower;
use pocketmine\entity\Entity;
use pocketmine\entity\Squid;
use pocketmine\entity\Villager;
use pocketmine\entity\Zombie;
use pocketmine\entity\Wolf;
use pocketmine\entity\Projectile;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\inventory\Fuel;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\level\Level;
use pocketmine\level\sound\LaunchSound;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use pocketmine\entity\Skeleton;
use pocketmine\entity\Witch;
use pocketmine\entity\PigZombie;
use pocketmine\entity\Spider;
use pocketmine\entity\CavernSpider;
use pocketmine\entity\Silverfish;
use pocketmine\utils\Config;
use pocketmine\Server;

class Item implements /*ItemIds,*/ \JsonSerializable{

	/** @var NBT */
	private static $cachedParser = null;

	/**
	 * @param $tag
	 * @return Compound
	 */
	private static function parseCompoundTag($tag){
		if(self::$cachedParser === null){
			self::$cachedParser = new NBT(NBT::LITTLE_ENDIAN);
		}

		self::$cachedParser->read($tag);
		return self::$cachedParser->getData();
	}

	/**
	 * @param CompoundTag $tag
	 * @return string
	 */
	private static function writeCompoundTag(CompoundTag $tag){
		if(self::$cachedParser === null){
			self::$cachedParser = new NBT(NBT::LITTLE_ENDIAN);
		}

		self::$cachedParser->setData($tag);
		return self::$cachedParser->write();
	}
		
	// All Block IDs are here too
	const AIR = 0;
	const STONE = 1;
	const GRASS = 2;
	const DIRT = 3;
	const COBBLESTONE = 4;
	const COBBLE = 4;
	const PLANK = 5;
	const PLANKS = 5;
	const WOODEN_PLANK = 5;
	const WOODEN_PLANKS = 5;
	const SAPLING = 6;
	const SAPLINGS = 6;
	const BEDROCK = 7;
	const WATER = 8;
	const STILL_WATER = 9;
	const LAVA = 10;
	const STILL_LAVA = 11;
	const SAND = 12;
	const GRAVEL = 13;
	const GOLD_ORE = 14;
	const IRON_ORE = 15;
	const COAL_ORE = 16;
	const LOG = 17;
	const WOOD = 17;
	const TRUNK = 17;
	const LEAVES = 18;
	const LEAVE = 18;
	const SPONGE = 19;
	const GLASS = 20;
	const LAPIS_ORE = 21;
	const LAPIS_BLOCK = 22;
	const DISPENSER = 23;
	const SANDSTONE = 24;
	const NOTEBLOCK = 25;
	const BED_BLOCK = 26;
	const POWERED_RAIL = 27;
	const DETECTOR_RAIL = 28;
	const STICKY_PISTON = 29;
	const COBWEB = 30;
	const TALL_GRASS = 31;
	const BUSH = 32;
	const DEAD_BUSH = 32;
	const PISTON = 33;
	const PISTON_HEAD = 34;
	const WOOL = 35;
	const DANDELION = 37;
	const POPPY = 38;
	const ROSE = 38;
	const RED_FLOWER = 38;
	const BROWN_MUSHROOM = 39;
	const RED_MUSHROOM = 40;
	const GOLD_BLOCK = 41;
	const IRON_BLOCK = 42;
	const DOUBLE_SLAB = 43;
	const DOUBLE_SLABS = 43;
	const SLAB = 44;
	const SLABS = 44;
	const STONE_SLAB = 44;
	const BRICKS = 45;
	const BRICKS_BLOCK = 45;
	const TNT = 46;
	const BOOKSHELF = 47;
	const MOSS_STONE = 48;
	const MOSSY_STONE = 48;
	const OBSIDIAN = 49;
	const TORCH = 50;
	const FIRE = 51;
	const MONSTER_SPAWNER = 52;
	const WOOD_STAIRS = 53;
	const WOODEN_STAIRS = 53;
	const OAK_WOOD_STAIRS = 53;
	const OAK_WOODEN_STAIRS = 53;
	const CHEST = 54;
	const REDSTONE_WIRE = 55;
	const DIAMOND_ORE = 56;
	const DIAMOND_BLOCK = 57;
	const CRAFTING_TABLE = 58;
	const WORKBENCH = 58;
	const WHEAT_BLOCK = 59;
	const FARMLAND = 60;
	const FURNACE = 61;
	const BURNING_FURNACE = 62;
	const LIT_FURNACE = 62;
	const SIGN_POST = 63;
	const DOOR_BLOCK = 64;
	const OAK_DOOR_BLOCK = 64;
	const WOOD_DOOR_BLOCK = 64;
	const LADDER = 65;
	const RAIL = 66;
	const COBBLESTONE_STAIRS = 67;
	const COBBLE_STAIRS = 67;
	const WALL_SIGN = 68;
	const LEVER = 69;
	const STONE_PRESSURE_PLATE = 70;
	const IRON_DOOR_BLOCK = 71;
	const WOODEN_PRESSURE_PLATE = 72;
	const REDSTONE_ORE = 73;
	const GLOWING_REDSTONE_ORE = 74;
	const LIT_REDSTONE_ORE = 74;
	const UNLIT_REDSTONE_TORCH = 75;
	const REDSTONE_TORCH = 76;
	const LIT_REDSTONE_TORCH = 76;
	const STONE_BUTTON = 77;
	const SNOW = 78;
	const SNOW_LAYER = 78;
	const ICE = 79;
	const SNOW_BLOCK = 80;
	const CACTUS = 81;
	const CLAY_BLOCK = 82;
	const REEDS = 83;
	const SUGARCANE_BLOCK = 83;
	// const JUKEBOX = 83;
	const FENCE = 85;
	const PUMPKIN = 86;
	const NETHERRACK = 87;
	const SOUL_SAND = 88;
	const GLOWSTONE = 89;
	const GLOWSTONE_BLOCK = 89;
	const PORTAL_BLOCK = 90;
	const NETHER_PORTAL = 90;
	const PORTAL = 90;
	const JACK_O_LANTERN = 91;
	const LIT_PUMPKIN = 91;
	const CAKE_BLOCK = 92;
	const UNPOWERED_REPEATER = 93;
	const REPEATER_BLOCK = 93;
	const UNPOWERED_REPEATER_BLOCK = 93;
	const POWERED_REPEATER_BLOCK = 94;
	const POWERED_REPEATER = 94;
	const INVISIBLE_BEDROCK = 95;
	const TRAPDOOR = 96;
	const WOODEN_TRAPDOOR = 96;
	const MONSTER_EGG_BLOCK = 97;
	const STONE_BRICKS = 98;
	const STONE_BRICK = 98;
	const BROWN_MUSHROOM_BLOCK = 99;
	const RED_MUSHROOM_BLOCK = 100;
	const IRON_BARS = 101;
	const IRON_BAR = 101;
	const GLASS_PANE = 102;
	const GLASS_PANEL = 102;
	const MELON_BLOCK = 103;
	const PUMPKIN_STEM = 104;
	const MELON_STEM = 105;
	const VINES = 106;
	const VINE = 106;
	const FENCE_GATE = 107;
	const OAK_FENCE_GATE = 107;
	const BRICK_STAIRS = 108;
	const STONE_BRICK_STAIRS = 109;
	const MYCELIUM = 110;
	const LILY_PAD = 111;
	const WATER_LILY = 111;
	const NETHER_BRICKS = 112;
	const NETHER_BRICK_BLOCK = 112;
	const NETHER_BRICK_FENCE = 113;
	const NETHER_BRICK_STAIRS = 114;
	const NETHER_BRICKS_STAIRS = 114;
	const NETHER_WART_BLOCK = 115;
	const ENCHANTING_TABLE = 116;
	const ENCHANT_TABLE = 116;
	const ENCHANTMENT_TABLE = 116;
	const BREWING_STAND_BLOCK = 117;
	const CAULDRON_BLOCK = 118;
	//const END_PORTAL = 119; //Confirmed
	const END_PORTAL_FRAME = 120;
	const END_STONE = 121;
	//const DRAGON_EGG = 122; //Confirmed
	const REDSTONE_LAMP = 123;
	const INACTIVE_REDSTONE_LAMP = 123;
	const LIT_REDSTONE_LAMP = 124;
	const ACTIVE_REDSTONE_LAMP = 124;
	const DROPPER = 125;
	const ACTIVATOR_RAIL = 126;
	const COCOA_BLOCK = 127;
	const COCOA_BEANS = 127;
	const COCOA_POD = 127;
	const COCOA_PODS = 127;
	const SANDSTONE_STAIRS = 128;
	const EMERALD_ORE = 129;
	//const ENDERCHEST = 130; //Confirmed
	const TRIPWIRE_HOOK = 131;
	const TRIPWIRE = 132;
	const EMERALD_BLOCK = 133;
	const SPRUCE_WOOD_STAIRS = 134;
	const SPRUCE_WOODEN_STAIRS = 134;
	const BIRCH_WOOD_STAIRS = 135;
	const BIRCH_WOODEN_STAIRS = 135;
	const JUNGLE_WOOD_STAIRS = 136;
	const JUNGLE_WOODEN_STAIRS = 136;
	const BEACON = 138;
	const COBBLESTONE_WALL = 139;
	const COBBLE_WALL = 139;
	const STONE_WALL = 139;
	const FLOWER_POT_BLOCK = 140;
	const CARROT_BLOCK = 141;
	const POTATO_BLOCK = 142;
	const WOODEN_BUTTON = 143;
	const SKULL_BLOCK = 144;
	const HEAD_BLOCK = 144;
	const MOB_HEAD_BLOCK = 144;
	const ANVIL_BLOCK = 145;
	const ANVIL = 145;
	const TRAPPED_CHEST = 146;
	const WEIGHTED_PRESSURE_PLATE_LIGHT = 147;
	const LIGHT_WEIGHTED_PRESSURE_PLATE = 147;
	const GOLD_PRESSURE_PLATE = 147;
	const WEIGHTED_PRESSURE_PLATE_HEAVY = 148;
	const HEAVY_WEIGHTED_PRESSURE_PLATE = 148;
	const IRON_PRESSURE_PLATE = 148;
	const COMPARATOR_BLOCK = 149;
	const UNPOWERED_COMPARATOR_BLOCK = 149;
	const UNPOWERED_COMPARATOR = 149;
	const POWERED_COMPARATOR = 150;
	const POWERED_COMPARATOR_BLOCK = 150;
	const DAYLIGHT_SENSOR = 151;
	const DAYLIGHT_DETECTOR = 151;
	const REDSTONE_BLOCK = 152;
	const NETHER_QUARTZ_ORE = 153;
	const QUARTZ_ORE = 153;
	const HOPPER_BLOCK = 154;
	const QUARTZ_BLOCK = 155;
	const QUARTZ_STAIRS = 156;
	const DOUBLE_WOOD_SLAB = 157;
	const DOUBLE_WOODEN_SLAB = 157;
	const DOUBLE_WOOD_SLABS = 157;
	const DOUBLE_WOODEN_SLABS = 157;
	const WOOD_SLAB = 158;
	const WOODEN_SLAB = 158;
	const WOOD_SLABS = 158;
	const WOODEN_SLABS = 158;
	const STAINED_CLAY = 159;
	const STAINED_HARDENED_CLAY = 159;
	//const STAINED_GLASS_PANE = 160; //Confirmed
	const LEAVES2 = 161;
	const LEAVE2 = 161;
	const WOOD2 = 162;
	const TRUNK2 = 162;
	const LOG2 = 162;
	const ACACIA_WOOD_STAIRS = 163;
	const ACACIA_WOODEN_STAIRS = 163;
	const DARK_OAK_WOOD_STAIRS = 164;
	const DARK_OAK_WOODEN_STAIRS = 164;
	const SLIME_BLOCK = 165;
	const SLIMEBLOCK = 165;
	//const BARRIER = 166;
	const IRON_TRAPDOOR = 167;
	const PRISMARINE = 168;
	const SEA_LANTERN = 169;
	const HAY_BALE = 170;
	const CARPET = 171;
	const HARDENED_CLAY = 172;
	const COAL_BLOCK = 173;
	const PACKED_ICE = 174;
	const DOUBLE_PLANT = 175;
	//const STANDING_BANNER = 176;
	//const WALL_BANNER = 177;
	const INVERTED_DAYLIGHT_SENSOR = 178;
	const DAYLIGHT_DETECTOR_INVERTED = 178;
	const DAYLIGHT_SENSOR_INVERTED = 178;
	const RED_SANDSTONE = 179;
	const RED_SANDSTONE_STAIRS = 180;
	const DOUBLE_RED_SANDSTONE_SLAB = 181;
	const DOUBLE_STONE_SLAB2 = 181;
	const STONE_SLAB2 = 182;
	const RED_SANDSTONE_SLAB = 182;
	const SPRUCE_FENCE_GATE = 183;
	const FENCE_GATE_SPRUCE = 183;
	const BIRCH_FENCE_GATE = 184; 
	const FENCE_GATE_BIRCH = 184;
	const JUNGLE_FENCE_GATE = 185;
	const FENCE_GATE_JUNGLE = 185;
	const DARK_OAK_FENCE_GATE = 186;
	const FENCE_GATE_DARK_OAK = 186;
	const ACACIA_FENCE_GATE = 187;
	const FENCE_GATE_ACACIA = 187;
	const SPRUCE_DOOR_BLOCK = 193;
	const BIRCH_DOOR_BLOCK = 194;
	const JUNGLE_DOOR_BLOCK = 195;
	const ACACIA_DOOR_BLOCK = 196;
	const DARK_OAK_DOOR_BLOCK = 197;
	const GRASS_PATH = 198;
	const ITEM_FRAME_BLOCK = 199;
	//const CHORUS_FLOWER = 200; //Confirmed
	//const PURPUR = 201; //Confirmed
	//const PURPUR_STAIRS = 203; //Confirmed
	//const END_BRICKS = 206; //Confirmed
	//const END_ROD = 208; //Confirmed
	//const END_GATEWAY = 209; //Confirmed
	//const CHORUS_PLANT = 240; //Confirmed
	//const STAINED_GLASS = 241; //Confirmed
	const PODZOL = 243;
	const BEETROOT_BLOCK = 244;
	const STONECUTTER = 245;
	const GLOWING_OBSIDIAN = 246;
	const NETHER_REACTOR = 247;
	const UPDATE_BLOCK = 248;
	const ATEUPD_BLOCK = 249;
	const PISTON_EXTENSION = 250;
	const BLOCK_MOVED_BY_PISTON = 250;
	const OBSERVER = 251;
	const RESERVED = 255;

	//Normal Item IDs
	const IRON_SHOVEL = 256;
	const IRON_PICKAXE = 257;
	const IRON_AXE = 258;
	const FLINT_AND_STEEL = 259;
	const FLINT_STEEL = 259;
	const APPLE = 260;
	const BOW = 261;
	const ARROW = 262;
	const TIPPED_ARROW = 262;
	const COAL = 263;
	const DIAMOND = 264;
	const IRON_INGOT = 265;
	const GOLD_INGOT = 266;
	const IRON_SWORD = 267;
	const WOODEN_SWORD = 268;
	const WOODEN_SHOVEL = 269;
	const WOODEN_PICKAXE = 270;
	const WOODEN_AXE = 271;
	const STONE_SWORD = 272;
	const STONE_SHOVEL = 273;
	const STONE_PICKAXE = 274;
	const STONE_AXE = 275;
	const DIAMOND_SWORD = 276;
	const DIAMOND_SHOVEL = 277;
	const DIAMOND_PICKAXE = 278;
	const DIAMOND_AXE = 279;
	const STICK = 280;
	const STICKS = 280;
	const BOWL = 281;
	const MUSHROOM_STEW = 282;
	const GOLD_SWORD = 283;
	const GOLDEN_SWORD = 283;
	const GOLD_SHOVEL = 284;
	const GOLDEN_SHOVEL = 284;
	const GOLD_PICKAXE = 285;
	const GOLDEN_PICKAXE = 285;
	const GOLD_AXE = 286;
	const GOLDEN_AXE = 286;
	const STRING = 287;
	const FEATHER = 288;
	const GUNPOWDER = 289;
	const WOODEN_HOE = 290;
	const STONE_HOE = 291;
	const IRON_HOE = 292;
	const DIAMOND_HOE = 293;
	const GOLD_HOE = 294;
	const GOLDEN_HOE = 294;
	const SEEDS = 295;
	const WHEAT_SEEDS = 295;
	const WHEAT = 296;
	const BREAD = 297;
	const LEATHER_CAP = 298;
	const LEATHER_TUNIC = 299;
	const LEATHER_PANTS = 300;
	const LEATHER_BOOTS = 301;
	const CHAIN_HELMET = 302;
	const CHAIN_CHESTPLATE = 303;
	const CHAIN_LEGGINGS = 304;
	const CHAIN_BOOTS = 305;
	const IRON_HELMET = 306;
	const IRON_CHESTPLATE = 307;
	const IRON_LEGGINGS = 308;
	const IRON_BOOTS = 309;
	const DIAMOND_HELMET = 310;
	const DIAMOND_CHESTPLATE = 311;
	const DIAMOND_LEGGINGS = 312;
	const DIAMOND_BOOTS = 313;
	const GOLD_HELMET = 314;
	const GOLD_CHESTPLATE = 315;
	const GOLD_LEGGINGS = 316;
	const GOLD_BOOTS = 317;
	const FLINT = 318;
	const RAW_PORKCHOP = 319;
	const COOKED_PORKCHOP = 320;
	const PAINTING = 321;
	const GOLDEN_APPLE = 322;
	const SIGN = 323;
	const WOODEN_DOOR = 324;
	const OAK_DOOR = 324;
	const BUCKET = 325;
	const MINECART = 328;
	const SADDLE = 329;
	const IRON_DOOR = 330;
	const REDSTONE = 331;
	const REDSTONE_DUST = 331;
	const SNOWBALL = 332;
	const BOAT = 333;
	const LEATHER = 334;
	
	const BRICK = 336;
	const CLAY = 337;
	const SUGARCANE = 338;
	const SUGAR_CANE = 338;
	const SUGAR_CANES = 338;
	const PAPER = 339;
	const BOOK = 340;
	const SLIMEBALL = 341;
	const CHEST_MINECART = 342;
	const MINECART_WITH_CHEST = 342;
	
	const EGG = 344;
	const COMPASS = 345;
	const FISHING_ROD = 346;
	const CLOCK = 347;
	const GLOWSTONE_DUST = 348;
	const RAW_FISH = 349;
	const COOKED_FISH = 350;
	const DYE = 351;
	const BONE = 352;
	const SUGAR = 353;
	const CAKE = 354;
	const BED = 355;
	const REPEATER = 356;
	const COOKIE = 357;
	const FILLED_MAP = 358;
	const SHEARS = 359;
	const MELON = 360;
	const MELON_SLICE = 360;
	const PUMPKIN_SEEDS = 361;
	const MELON_SEEDS = 362;
	const RAW_BEEF = 363;
	const STEAK = 364;
	const COOKED_BEEF = 364;
	const RAW_CHICKEN = 365;
	const COOKED_CHICKEN = 366;
	const ROTTEN_FLESH = 367;
	//const ENDERPEARL = 368; //Confirmed
	const BLAZE_ROD = 369;
	const GHAST_TEAR = 370;
	const GOLD_NUGGET = 371;
	const GOLDEN_NUGGET = 371;
	const NETHER_WART = 372;
	const POTION = 373;
	const GLASS_BOTTLE = 374;
	const SPIDER_EYE = 375;
	const FERMENTED_SPIDER_EYE = 376;
	const BLAZE_POWDER = 377;
	const MAGMA_CREAM = 378;
	const BREWING_STAND = 379;
	const CAULDRON = 380;
	const EYE_OF_ENDER = 380;
	const GLISTERING_MELON = 382;
	const SPAWN_EGG = 383;
	const BOTTLE_O_ENCHANTING = 384;
	const ENCHANTING_BOTTLE = 384;
	const EXP_BOTTLE = 384;
	const FIRE_CHARGE = 385;
	
	const EMERALD = 388;
	const ITEM_FRAME = 389;
	const FLOWER_POT = 390;
	const CARROT = 391;
	const CARROTS = 391;
	const POTATO = 392;
	const POTATOES = 392;
	const BAKED_POTATO = 393;
	const BAKED_POTATOES = 393;
	const POISONOUS_POTATO = 394;
	const MAP = 395;
	const EMPTY_MAP = 395;
	const GOLDEN_CARROT = 396;
	const MOB_HEAD = 397;
	const SKULL = 397;
	const CARROT_ON_A_STICK = 398;
	const NETHER_STAR = 399;
	const PUMPKIN_PIE = 400;
	const ENCHANTED_BOOK = 403;
	const COMPARATOR = 404;
	const NETHER_BRICK = 405;
	const QUARTZ = 406;
	const NETHER_QUARTZ = 406;
	const TNT_MINECART = 407;
	const MINECART_WITH_TNT = 407;
	const HOPPER_MINECART = 408;
	const MINECART_WITH_HOPPER = 408;
	const PRISMARINE_SHARD = 409;
	const HOPPER = 410;
	const RAW_RABBIT = 411;
	const COOKED_RABBIT = 412;
	const RABBIT_STEW = 413;
	const RABBIT_FOOT = 414;
	const RABBIT_HIDE = 415;
	const LEATHER_HORSE_ARMOR = 416;
	const IRON_HORSE_ARMOR = 417;
	const GOLD_HORSE_ARMOR = 418;
	const GOLDEN_HORSE_ARMOR = 418;
	const DIAMOND_HORSE_ARMOR = 419;
	const LEAD = 420;
	const LEASH = 420;
	const NAME_TAG = 421;
	const PRISMARINE_CRYSTAL = 422;
	const PRISMARINE_CRYSTALS = 422;
	const RAW_MUTTON = 423;
	const COOKED_MUTTON = 424;
	//const END_CRYSTAL = 426; //Confirmed
	
	const SPRUCE_DOOR = 427;
	const BIRCH_DOOR = 428;
	const JUNGLE_DOOR = 429;
	const ACACIA_DOOR = 430;
	const DARK_OAK_DOOR = 431;
	//const CHORUS_FRUIT = 432; //Confirmed
	//const POPPED_CHORUS_FRUIT = 433; //Confirmed
	
	//const DRAGON_BREATH = 437; //Confirmed
	//const DRAGONS_BREATH = 437; //Confirmed
	const SPLASH_POTION = 438;
	
	//const LINGERING_POTION = 441; //Confirmed
	
	//const ELYTRA = 444; //Confirmed
	
	const BEETROOT = 457;
	const BEETROOT_SEEDS = 458;
	const BEETROOT_SEED = 458;
	const BEETROOT_SOUP = 459;
	const RAW_SALMON = 460;
	const CLOWN_FISH = 461;
	const PUFFERFISH = 462;
	const COOKED_SALMON = 463;
	const ENCHANTED_GOLDEN_APPLE = 466;
	const CAMERA = 498;


	/** @var \SplFixedArray */
	public static $list = null;
	protected $block;
	protected $id;
	protected $meta;
	private $tags = "";
	private $cachedNBT = null;
	public $count;
	protected $durability = 0;
	protected $name;
	protected $exp_smelt = 0;
	protected $entityname = null;
	protected $f = 1.0;
	
	/** Launchable Mod **/
	public function isLaunchable(){
		return false;
	}
	
	public function Launch(Player $player){
 		$nbt = new CompoundTag("", [
			"Pos" => new ListTag("Pos", [
				new DoubleTag("", $player->x),
				new DoubleTag("", $player->y + $player->getEyeHeight()),
				new DoubleTag("", $player->z)
			]),
 			"Motion" => new ListTag("Motion", [
				new DoubleTag("", -sin($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI)),
				new DoubleTag("", -sin($player->pitch / 180 * M_PI)),
				new DoubleTag("", cos($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI))
			]),
			"Rotation" => new ListTag("Rotation", [
				new FloatTag("", $player->yaw),
				new FloatTag("", $player->pitch)
			]),
			"Data" => new ByteTag("Data", $this->getDamage()),
		]);
		$f = $this->f;
		$launched = Entity::createEntity($this->getEntityName(), $player->chunk, $nbt, $player);
		$launched->setNameTag($this->getCustomName());
		$launched->setMotion($launched->getMotion()->multiply($f));
		if($launched instanceof Projectile){
			$player->getServer()->getPluginManager()->callEvent($projectileEv = new ProjectileLaunchEvent($launched));
			if($projectileEv->isCancelled()){
				$launched->kill();
			}else{
				$launched->spawnToAll();
				$player->level->addSound(new LaunchSound($player), $player->getViewers());
			}
		}else{
			$launched->spawnToAll();
		}
		return true;
	}

	public function canBeActivated(){
		return false;
	}

	public static function init(){
		if(self::$list === null){
			self::$list = new \SplFixedArray(65536);
			self::$list[self::IRON_SHOVEL] = IronShovel::class;
			self::$list[self::IRON_PICKAXE] = IronPickaxe::class;
			self::$list[self::IRON_AXE] = IronAxe::class;
			self::$list[self::FLINT_STEEL] = FlintSteel::class;
			self::$list[self::APPLE] = Apple::class;
			self::$list[self::BOW] = Bow::class;
			self::$list[self::ARROW] = Arrow::class;
			self::$list[self::COAL] = Coal::class;
			self::$list[self::DIAMOND] = Diamond::class;
			self::$list[self::IRON_INGOT] = IronIngot::class;
			self::$list[self::GOLD_INGOT] = GoldIngot::class;
			self::$list[self::IRON_SWORD] = IronSword::class;
			self::$list[self::WOODEN_SWORD] = WoodenSword::class;
			self::$list[self::WOODEN_SHOVEL] = WoodenShovel::class;
			self::$list[self::WOODEN_PICKAXE] = WoodenPickaxe::class;
			self::$list[self::WOODEN_AXE] = WoodenAxe::class;
			self::$list[self::STONE_SWORD] = StoneSword::class;
			self::$list[self::STONE_SHOVEL] = StoneShovel::class;
			self::$list[self::STONE_PICKAXE] = StonePickaxe::class;
			self::$list[self::STONE_AXE] = StoneAxe::class;
			self::$list[self::DIAMOND_SWORD] = DiamondSword::class;
			self::$list[self::DIAMOND_SHOVEL] = DiamondShovel::class;
			self::$list[self::DIAMOND_PICKAXE] = DiamondPickaxe::class;
			self::$list[self::DIAMOND_AXE] = DiamondAxe::class;
			self::$list[self::STICK] = Stick::class;
			self::$list[self::BOWL] = Bowl::class;
			self::$list[self::MUSHROOM_STEW] = MushroomStew::class;
			self::$list[self::GOLD_SWORD] = GoldSword::class;
			self::$list[self::GOLD_SHOVEL] = GoldShovel::class;
			self::$list[self::GOLD_PICKAXE] = GoldPickaxe::class;
			self::$list[self::GOLD_AXE] = GoldAxe::class;
			self::$list[self::STRING] = StringItem::class;
			self::$list[self::FEATHER] = Feather::class;
			self::$list[self::GUNPOWDER] = Gunpowder::class;
			self::$list[self::WOODEN_HOE] = WoodenHoe::class;
			self::$list[self::STONE_HOE] = StoneHoe::class;
			self::$list[self::IRON_HOE] = IronHoe::class;
			self::$list[self::DIAMOND_HOE] = DiamondHoe::class;
			self::$list[self::GOLD_HOE] = GoldHoe::class;
			self::$list[self::WHEAT_SEEDS] = WheatSeeds::class;
			self::$list[self::WHEAT] = Wheat::class;
			self::$list[self::BREAD] = Bread::class;
			self::$list[self::LEATHER_CAP] = LeatherCap::class;
			self::$list[self::LEATHER_TUNIC] = LeatherTunic::class;
			self::$list[self::LEATHER_PANTS] = LeatherPants::class;
			self::$list[self::LEATHER_BOOTS] = LeatherBoots::class;
			self::$list[self::CHAIN_HELMET] = ChainHelmet::class;
			self::$list[self::CHAIN_CHESTPLATE] = ChainChestplate::class;
			self::$list[self::CHAIN_LEGGINGS] = ChainLeggings::class;
			self::$list[self::CHAIN_BOOTS] = ChainBoots::class;
			self::$list[self::IRON_HELMET] = IronHelmet::class;
			self::$list[self::IRON_CHESTPLATE] = IronChestplate::class;
			self::$list[self::IRON_LEGGINGS] = IronLeggings::class;
			self::$list[self::IRON_BOOTS] = IronBoots::class;
			self::$list[self::DIAMOND_HELMET] = DiamondHelmet::class;
			self::$list[self::DIAMOND_CHESTPLATE] = DiamondChestplate::class;
			self::$list[self::DIAMOND_LEGGINGS] = DiamondLeggings::class;
			self::$list[self::DIAMOND_BOOTS] = DiamondBoots::class;
			self::$list[self::GOLD_HELMET] = GoldHelmet::class;
			self::$list[self::GOLD_CHESTPLATE] = GoldChestplate::class;
			self::$list[self::GOLD_LEGGINGS] = GoldLeggings::class;
			self::$list[self::GOLD_BOOTS] = GoldBoots::class;
			self::$list[self::FLINT] = Flint::class;
			self::$list[self::RAW_PORKCHOP] = RawPorkchop::class;
			self::$list[self::COOKED_PORKCHOP] = CookedPorkchop::class;
			self::$list[self::PAINTING] = Painting::class;
			self::$list[self::GOLDEN_APPLE] = GoldenApple::class;
			self::$list[self::SIGN] = Sign::class;
			self::$list[self::OAK_DOOR] = OakDoor::class;
			self::$list[self::ACACIA_DOOR] = AcaciaDoor::class;
			self::$list[self::BIRCH_DOOR] = BirchDoor::class;
			self::$list[self::DARK_OAK_DOOR] = DarkOakDoor::class;
			self::$list[self::JUNGLE_DOOR] = JungleDoor::class;
			self::$list[self::SPRUCE_DOOR] = SpruceDoor::class;
			self::$list[self::IRON_DOOR] = IronDoor::class;	

			self::$list[self::BUCKET] = Bucket::class;
			
			self::$list[self::MINECART] = Minecart::class;
			//self::$list[self::SADDLE] = Saddle::class;
			
			self::$list[self::IRON_DOOR] = IronDoor::class;
			self::$list[self::REDSTONE] = Redstone::class;
			self::$list[self::SNOWBALL] = Snowball::class;
			self::$list[self::BOAT] = Boat::class;
			
			self::$list[self::LEATHER] = Leather::class;
			
			self::$list[self::BRICK] = Brick::class;
			self::$list[self::CLAY] = Clay::class;
			self::$list[self::SUGARCANE] = Sugarcane::class;
			self::$list[self::PAPER] = Paper::class;
			self::$list[self::BOOK] = Book::class;
			self::$list[self::SLIMEBALL] = Slimeball::class;
			self::$list[self::MINECART_WITH_CHEST] = MinecartChest::class;
			
			self::$list[self::EGG] = Egg::class;
			self::$list[self::COMPASS] = Compass::class;
			self::$list[self::FISHING_ROD] = FishingRod::class;
			
			self::$list[self::CLOCK] = Clock::class;
			self::$list[self::GLOWSTONE_DUST] = GlowstoneDust::class;
			self::$list[self::RAW_FISH] = Fish::class;
			self::$list[self::COOKED_FISH] = CookedFish::class;
			self::$list[self::DYE] = Dye::class;
			self::$list[self::BONE] = Bone::class;
			self::$list[self::SUGAR] = Sugar::class;
			self::$list[self::CAKE] = Cake::class;
			self::$list[self::BED] = Bed::class;
			
			self::$list[self::COOKIE] = Cookie::class;
			self::$list[self::EMPTY_MAP] = EmptyMap::class;
			
			self::$list[self::SHEARS] = Shears::class;
			self::$list[self::MELON] = Melon::class;
			self::$list[self::PUMPKIN_SEEDS] = PumpkinSeeds::class;
			self::$list[self::MELON_SEEDS] = MelonSeeds::class;
			self::$list[self::RAW_BEEF] = RawBeef::class;
			self::$list[self::STEAK] = Steak::class;
			
			self::$list[self::RAW_CHICKEN] = RawChicken::class;
			self::$list[self::COOKED_CHICKEN] = CookedChicken::class;
			
			self::$list[self::ROTTEN_FLESH] = RottenFlesh::class;
			self::$list[self::BLAZE_ROD] = BlazeRod::class;
			self::$list[self::GHAST_TEAR] = GhastTear::class;
			self::$list[self::GOLD_NUGGET] = GoldNugget::class;
			self::$list[self::NETHER_WART] = NetherWart::class;
			self::$list[self::POTION] = Potion::class;
			self::$list[self::GLASS_BOTTLE] = GlassBottle::class;
			self::$list[self::SPIDER_EYE] = Spidereye::class;
			self::$list[self::FERMENTED_SPIDER_EYE] = FermentedSpiderEye::class;
			self::$list[self::BLAZE_POWDER] = BlazePowder::class;
			self::$list[self::MAGMA_CREAM] = MagmaCream::class;
			self::$list[self::BREWING_STAND] = BrewingStand::class;
			self::$list[self::CAULDRON] = Cauldron::class;
			self::$list[self::GLISTERING_MELON] = GlisteringMelon::class;
			
			self::$list[self::SPAWN_EGG] = SpawnEgg::class;
			self::$list[self::EXP_BOTTLE] = EXPBottle::class;
			
			self::$list[self::EMERALD] = Emerald::class;
			self::$list[self::ITEM_FRAME] = ItemFrame::class;
			self::$list[self::FLOWER_POT] = FlowerPot::class;
			
			self::$list[self::CARROT] = Carrot::class;
			self::$list[self::POTATO] = Potato::class;
			self::$list[self::BAKED_POTATO] = BakedPotato::class;
			self::$list[self::POISONOUS_POTATO] = PoisonousPotato::class;
			self::$list[self::FILLED_MAP] = FilledMap::class;
			self::$list[self::GOLDEN_CARROT] = GoldenCarrot::class;
			self::$list[self::SKULL] = Skull::class;
			self::$list[self::NETHER_STAR] = NetherStar::class;
			self::$list[self::PUMPKIN_PIE] = PumpkinPie::class;
			
			self::$list[self::ENCHANTED_BOOK] = EnchantedBook::class;
			self::$list[self::COMPARATOR] = RedstoneComparator::class;
			
			self::$list[self::NETHER_BRICK] = NetherBrick::class;
			self::$list[self::QUARTZ] = NetherQuartz::class;
			self::$list[self::MINECART_WITH_TNT] = MinecartTNT::class;
			self::$list[self::MINECART_WITH_HOPPER] = MinecartHopper::class;
			self::$list[self::HOPPER] = Hopper::class;

			self::$list[self::RAW_RABBIT] = RawRabbit::class;
			self::$list[self::COOKED_RABBIT] = CookedRabbit::class;
			self::$list[self::RABBIT_STEW] = RabbitStew::class;
			self::$list[self::RABBIT_FOOT] = RabbitFoot::class;
			
			self::$list[self::SPLASH_POTION] = SplashPotion::class;
			
			// self::$list[self::CAMERA] = Camera::class;
			self::$list[self::BEETROOT] = Beetroot::class;
			self::$list[self::BEETROOT_SEEDS] = BeetrootSeeds::class;
			self::$list[self::BEETROOT_SOUP] = BeetrootSoup::class;
			//self::$list[self::RAW_SALMON] = RawSalmon::class;
			//self::$list[self::CLOWN_FISH] = CLOWN_FISH::class;
			//self::$list[self::PUFFERFISH] = Pufferfish::class;
			//self::$list[self::COOKED_SALMON] = CookedSalmon::class;
			self::$list[self::ENCHANTED_GOLDEN_APPLE] = EnchantedGoldenApple::class;

			for($i = 0; $i < 256; ++$i){
				if(Block::$list[$i] !== null){
					self::$list[$i] = Block::$list[$i];
				}
			}
		}

		self::initCreativeItems();
	}

	private static $creative = [];

	private static function initCreativeItems(){
		self::clearCreativeItems();
		$creativeItems = new Config(Server::getInstance()->getFilePath() . "src/pocketmine/resources/creativeitems.json", Config::JSON, []);
		foreach($creativeItems->getAll() as $data){
			$item = Item::get($data["id"], $data["damage"], $data["count"], $data["nbt"]);
			if($item->getName() === "Unknown"){
				continue;
			}
			self::addCreativeItem($item);
		}
	}
	
	public static function clearCreativeItems(){
		Item::$creative = [];
	}

	public static function getCreativeItems(){
		return Item::$creative;
	}

	public static function addCreativeItem(Item $item){
		Item::$creative[] = clone $item;
	}

	public static function removeCreativeItem(Item $item){
		$index = self::getCreativeItemIndex($item);
		if($index !== -1){
			unset(Item::$creative[$index]);
		}
	}

	public static function isCreativeItem(Item $item){
		foreach(Item::$creative as $i => $d){
			if($item->equals($d, !$item->isTool())){
				return true;
			}
		}

		return false;
	}

	/**
	 * @param $index
	 * @return Item
	 */
	public static function getCreativeItem(int $index){
		return Item::$creative[$index] ?? null;
	}

	/**
	 * @param Item $item
	 * @return int
	 */
	public static function getCreativeItemIndex(Item $item){
		foreach(Item::$creative as $i => $d){
			if($item->equals($d, !$item->isTool())){
				return $i;
			}
		}

		return -1;
	}

	public static function get($id, $meta = 0, $count = 1, $tags = ""){
		try{
			$class = self::$list[$id];
			if($class === null){
				return (new Item($id, $meta, $count))->setCompoundTag($tags);
			}elseif($id < 256){
				return (new ItemBlock(new $class($meta), $meta, $count))->setCompoundTag($tags);
			}else{
				return (new $class($meta, $count))->setCompoundTag($tags);
			}
		}catch(\RuntimeException $e){
			return (new Item($id, $meta, $count))->setCompoundTag($tags);
		}
	}

	public static function fromString($str, $multiple = false){
		if($multiple === true){
			$blocks = [];
			foreach(explode(",", $str) as $b){
				$blocks[] = self::fromString($b, false);
			}

			return $blocks;
		}else{
			$b = explode(":", str_replace([" ", "minecraft:"], ["_", ""], trim($str)));
			if(!isset($b[1])){
				$meta = 0;
			}else{
				$meta = $b[1] & 0xFFFF;
			}

			if(defined(Item::class . "::" . strtoupper($b[0]))){
				$item = self::get(constant(Item::class . "::" . strtoupper($b[0])), $meta);
				if($item->getId() === self::AIR and strtoupper($b[0]) !== "AIR"){
					$item = self::get($b[0] & 0xFFFF, $meta);
				}
			}else{
				$item = self::get($b[0] & 0xFFFF, $meta);
			}

			return $item;
		}
	}

	public function __construct($id, $meta = 0, $count = 1, $name = "Unknown"){
		$this->id = $id & 0xffff;
		$this->meta = $meta !== null ? $meta & 0xffff : null;
		$this->count = (int) $count;
		$this->name = $name;
		if(!isset($this->block) and $this->id <= 0xff and isset(Block::$list[$this->id])){
			$this->block = Block::get($this->id, $this->meta);
			$this->name = $this->block->getName();
		}
	}

	public function setCompoundTag($tags){
		if($tags instanceof CompoundTag){
			$this->setNamedTag($tags);
		}else{
			$this->tags = $tags;
			$this->cachedNBT = null;
		}

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCompoundTag(){
		return $this->tags;
	}

	public function hasCompoundTag(){
		return $this->tags !== "" and $this->tags !== null;
	}

	public function hasCustomBlockData(){
		if(!$this->hasCompoundTag()){
			return false;
		}

		$tag = $this->getNamedTag();
		if(isset($tag->BlockEntityTag) and $tag->BlockEntityTag instanceof CompoundTag){
			return true;
		}

		return false;
	}

	public function clearCustomBlockData(){
		if(!$this->hasCompoundTag()){
			return $this;
		}
		$tag = $this->getNamedTag();

		if(isset($tag->BlockEntityTag) and $tag->BlockEntityTag instanceof CompoundTag){
			unset($tag->display->BlockEntityTag);
			$this->setNamedTag($tag);
		}

		return $this;
	}

	public function setCustomBlockData(CompoundTag $compound){
		$tags = clone $compound;
		$tags->setName("BlockEntityTag");

		if(!$this->hasCompoundTag()){
			$tag = new CompoundTag("", []);
		}else{
			$tag = $this->getNamedTag();
		}

		$tag->BlockEntityTag = $tags;
		$this->setNamedTag($tag);

		return $this;
	}

	public function getCustomBlockData(){
		if(!$this->hasCompoundTag()){
			return null;
		}

		$tag = $this->getNamedTag();
		if(isset($tag->BlockEntityTag) and $tag->BlockEntityTag instanceof CompoundTag){
			return $tag->BlockEntityTag;
		}

		return null;
	}

	public function hasEnchantments(){
		if(!$this->hasCompoundTag()){
			return false;
		}
		$tag = $this->getNamedTag();
		if(isset($tag->ench)){
			$tag = $tag->ench;
			if($tag instanceof ListTag){
				return true;
			}
		}
		return false;
	}
	/**
	 * @param $id
	 * @return Enchantment|null
	 */
	public function getEnchantment(int $id){
		if(!$this->hasEnchantments()){
			return null;
		}
		foreach($this->getNamedTag()->ench as $entry){
			if($entry["id"] === $id){
				$e = Enchantment::getEnchantment($entry["id"]);
				$e->setLevel($entry["lvl"]);
				return $e;
			}
		}
		return null;
	}
	/**
	 * @param int  $id
	 * @param int  $level
	 * @param bool $compareLevel
	 * @return bool
	 */
	public function hasEnchantment(int $id, int $level = 1, bool $compareLevel = false){
		if($this->hasEnchantments()){
			foreach($this->getEnchantments() as $enchantment){
				if($enchantment->getId() == $id){
					if($compareLevel){
						if($enchantment->getLevel() == $level){
							return true;
						}
					}else{
						return true;
					}
				}
			}
		}
		return false;
	}
	
	/**
	 * @param $id
	 * @return Int level|0(for null)
	 */
	public function getEnchantmentLevel(int $id){
		if(!$this->hasEnchantments()){
			return 0;
		}
		foreach($this->getNamedTag()->ench as $entry){
			if($entry["id"] === $id){
				$e = Enchantment::getEnchantment($entry["id"]);
				$e->setLevel($entry["lvl"]);
				$E_level = $e->getLevel() > Enchantment::getEnchantMaxLevel($id) ? Enchantment::getEnchantMaxLevel($id) : $e->getLevel();
				return $E_level;
			}
		}
		return 0;
	}
	/**
	 * @param Enchantment $ench
	 */
	public function addEnchantment(Enchantment $ench){
		if(!$this->hasCompoundTag()){
			$tag = new CompoundTag("", []);
		}else{
			$tag = $this->getNamedTag();
		}
		if(!isset($tag->ench)){
			$tag->ench = new ListTag("ench", []);
			$tag->ench->setTagType(NBT::TAG_Compound);
		}
		$found = false;
		foreach($tag->ench as $k => $entry){
			if($entry["id"] === $ench->getId()){
				$tag->ench->{$k} = new CompoundTag("", [
					"id" => new ShortTag("id", $ench->getId()),
					"lvl" => new ShortTag("lvl", $ench->getLevel())
				]);
				$found = true;
				break;
			}
		}
		if(!$found){
			$count = 0;
			foreach($tag->ench as $key => $value){
				if(is_numeric($key)){
					$count++;
				}
			}
			$tag->ench->{$count + 1} = new CompoundTag("", [
				"id" => new ShortTag("id", $ench->getId()),
				"lvl" => new ShortTag("lvl", $ench->getLevel())
			]);
		}
		$this->setNamedTag($tag);
	}
	/**
	 * @return Enchantment[]
	 */
	public function getEnchantments(){
		if(!$this->hasEnchantments()){
			return [];
		}
		$enchantments = [];
		foreach($this->getNamedTag()->ench as $entry){
			$e = Enchantment::getEnchantment($entry["id"]);
			$e->setLevel($entry["lvl"]);
			$enchantments[] = $e;
		}
		return $enchantments;
	}

	public function hasRepairCost(){
		if(!$this->hasCompoundTag()){
			return false;
		}
		$tag = $this->getNamedTag();
		if(isset($tag->RepairCost)){
			$tag = $tag->RepairCost;
			if($tag instanceof IntTag){
				return true;
			}
		}
		return false;
	}

	public function getRepairCost(){
		if(!$this->hasCompoundTag()){
			return 1;
		}
		$tag = $this->getNamedTag();
		if(isset($tag->display)){
			$tag = $tag->RepairCost;
			if($tag instanceof IntTag){
				return $tag->getValue();
			}
		}
		return 1;
	}

	public function setRepairCost(int $cost){
		if($cost === 1){
			$this->clearRepairCost();
		}
		if(!($hadCompoundTag = $this->hasCompoundTag())){
			$tag = new CompoundTag("", []);
		}else{
			$tag = $this->getNamedTag();
		}
		$tag->RepairCost = new IntTag("RepairCost", $cost);
		if(!$hadCompoundTag){
			$this->setCompoundTag($tag);
		}
		return $this;
	}

	public function clearRepairCost(){
		if(!$this->hasCompoundTag()){
			return $this;
		}
		$tag = $this->getNamedTag();
		if(isset($tag->RepairCost) and $tag->RepairCost instanceof IntTag){
			unset($tag->RepairCost);
			$this->setNamedTag($tag);
		}
		return $this;
	}

	public function hasCustomName(){
		if(!$this->hasCompoundTag()){
			return false;
		}
		$tag = $this->getNamedTag();
		if(isset($tag->display)){
			$tag = $tag->display;
			if($tag instanceof CompoundTag and isset($tag->Name) and $tag->Name instanceof StringTag){
				return true;
			}
		}
		return false;
	}

	public function getCustomName(){
		if(!$this->hasCompoundTag()){
			return "";
		}
		$tag = $this->getNamedTag();
		if(isset($tag->display)){
			$tag = $tag->display;
			if($tag instanceof CompoundTag and isset($tag->Name) and $tag->Name instanceof StringTag){
				return $tag->Name->getValue();
			}
		}
		return "";
	}

	public function setCustomName(string $name){
		if($name === ""){
			$this->clearCustomName();
		}
		if(!($hadCompoundTag = $this->hasCompoundTag())){
			$tag = new CompoundTag("", []);
		}else{
			$tag = $this->getNamedTag();
		}
		if(isset($tag->display) and $tag->display instanceof CompoundTag){
			$tag->display->Name = new StringTag("Name", $name);
		}else{
			$tag->display = new CompoundTag("display", [
				"Name" => new StringTag("Name", $name)
			]);
		}
		if(!$hadCompoundTag){
			$this->setCompoundTag($tag);
		}
		return $this;
	}

	public function clearCustomName(){
		if(!$this->hasCompoundTag()){
			return $this;
		}
		$tag = $this->getNamedTag();
		if(isset($tag->display) and $tag->display instanceof CompoundTag){
			unset($tag->display->Name);
			if($tag->display->getCount() === 0){
				unset($tag->display);
			}
			$this->setNamedTag($tag);
		}
		return $this;
	}

	public function getNamedTagEntry($name){
		$tag = $this->getNamedTag();
		if($tag !== null){
			return $tag->{$name} ?? null;
		}
		return null;
	}

	public function getNamedTag(){
		if(!$this->hasCompoundTag()){
			return null;
		}elseif($this->cachedNBT !== null){
			return $this->cachedNBT;
		}
		return $this->cachedNBT = self::parseCompoundTag($this->tags);
	}

	public function setNamedTag(CompoundTag $tag){
		if($tag->getCount() === 0){
			return $this->clearNamedTag();
		}
		$this->cachedNBT = $tag;
		$this->tags = self::writeCompoundTag($tag);
		return $this;
	}

	public function clearNamedTag(){
		return $this->setCompoundTag("");
	}

	public function getCount(){
		return $this->count;
	}

	public function setCount($count){
		$this->count = (int) $count;
	}

	final public function getName(){
		return $this->hasCustomName() ? $this->getCustomName() : $this->name;
	}
	
	final public function getEntityName(){
		return $this->entityname === null ? $this->name : $this->entityname;
	}
	
	final public function canBePlaced(){
		return $this->block !== null and $this->block->canBePlaced();
	}

	final public function isPlaceable(){
		$this->canBePlaced();
	}

	public function canBeConsumed(){
		return false;
	}

	public function canBeConsumedBy(Entity $entity){
		return $this->canBeConsumed();
	}

	public function onConsume(Entity $entity){
	}

	public function getBlock(){
		if($this->block instanceof Block){
			return clone $this->block;
		}else{
			return Block::get(self::AIR);
		}
	}

	final public function getId(){
		return $this->id;
	}

	final public function getDamage(){
		return $this->meta;
	}

	public function setDamage($meta){
		$this->meta = $meta !== null ? $meta & 0xFFFF : null;
	}

	public function getMaxStackSize(){
		return 64;
	}

	final public function getFuelTime(){
		if(!isset(Fuel::$duration[$this->id])){
			return null;
		}
		if($this->id !== self::BUCKET or $this->meta === 10){
			return Fuel::$duration[$this->id];
		}

		return null;
	}
	
	public function getExperience(){
		return $this->exp_smelt;
	}

	/**
	 * @param Entity|Block $object
	 *
	 * @return bool
	 */
	public function useOn($object){
		return false;
	}

	/**
	 * @param Entity $entity, Entity $origin (who uses it)
	 *
	 * @return bool
	 */
	public function useOnEntity(Entity $entity, Entity $origin){
		return false;
	}

	/**
	 * @return bool
	 */
	public function isTool(){
		return false;
	}

	/**
	 * @return int|bool
	 */
	public function getMaxDurability(){
		return false;
	}

	public function isPickaxe(){
		return false;
	}

	public function isAxe(){
		return false;
	}

	public function isSword(){
		return false;
	}

	public function isShovel(){
		return false;
	}

	public function isHoe(){
		return false;
	}

	public function isShears(){
		return false;
	}

	public function isArmor(){
		return false;
	}

	public function getArmorValue(){
		return false;
	}

	public function isBoots(){
		return false;
	}

	public function isHelmet(){
		return false;
	}

	public function isLeggings(){
		return false;
	}

	public function isChestplate(){
		return false;
	}

	public function getAttackDamage(){
		return 1;
	}

	public function getModifyAttackDamage(Entity $target){
		$rec = $this->getAttackDamage();
		$sharpL = $this->getEnchantmentLevel(Enchantment::TYPE_WEAPON_SHARPNESS);
		if($sharpL > 0){
			$rec += 0.5 * ($sharpL + 1);
		}

		if($target instanceof Skeleton or $target instanceof Zombie or
			$target instanceof Witch or $target instanceof PigZombie){
			//SMITE    wither skeletons
			$rec += 2.5 * $this->getEnchantmentLevel(Enchantment::TYPE_WEAPON_SMITE);

		}elseif($target instanceof Spider or $target instanceof CavernSpider or
			$target instanceof Silverfish){
			//Bane of Arthropods    wither skeletons
			$rec += 2.5 * $this->getEnchantmentLevel(Enchantment::TYPE_WEAPON_ARTHROPODS);

		}
		return $rec;
	}

	final public function __toString(){
		return "Item " . $this->name . " (" . $this->id . ":" . ($this->meta === null ? "?" : $this->meta) . ")x" . $this->count . ($this->hasCompoundTag() ? " tags:0x".bin2hex($this->getCompoundTag()) : "");
	}

	public function getDestroySpeed(Block $block, Player $player){
		return 1;
	}

	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		return false;
	}
	
	public final function equals(Item $item, $checkDamage = true, $checkCompound = true, $checkCount = false){
		return $this->id === $item->getId() and ($checkCount === false or $this->getCount() === $item->getCount()) and($checkDamage === false or $this->getDamage() === $item->getDamage()) and ($checkCompound === false or $this->getCompoundTag() === $item->getCompoundTag());
	}

	public final function deepEquals(Item $item, $checkDamage = true, $checkCompound = true, $checkCount = false){
		if($this->equals($item, $checkDamage, $checkCompound, $checkCount)){
			return true;
		}elseif($item->hasCompoundTag() and $this->hasCompoundTag()){
			return NBT::matchTree($this->getNamedTag(), $item->getNamedTag());
		}
		return false;
	}

	/**
	 * Serializes the item to an NBT CompoundTag
	 *
	 * @param int $slot optional, the inventory slot of the item
	 *
	 * @return CompoundTag
	 */
	public function nbtSerialize(int $slot = -1, string $tagName = "") : CompoundTag{
		$tag = new CompoundTag($tagName, [
			"id" => new ShortTag("id", $this->id),
			"Count" => new ByteTag("Count", $this->count ?? -1),
			"Damage" => new ShortTag("Damage", $this->meta),
		]);

		if($this->hasCompoundTag()){
			$tag->tag = clone $this->getNamedTag();
			$tag->tag->setName("tag");
		}
		
		if($slot !== -1){
			$tag->Slot = new ByteTag("Slot", $slot);
		}

		return $tag;
	}

	/**
	 * Deserializes an Item from an NBT CompoundTag
	 *
	 * @param CompoundTag $tag
	 *
	 * @return Item
	 */
	public static function nbtDeserialize(CompoundTag $tag) : Item{
		if(!isset($tag->id) or !isset($tag->Count)){
			return Item::get(0);
		}

		if($tag->id instanceof ShortTag){
			$item = Item::get($tag->id->getValue(), !isset($tag->Damage) ? 0 : $tag->Damage->getValue(), $tag->Count->getValue());
		}elseif($tag->id instanceof StringTag){ //PC item save format
			$item = Item::fromString($tag->id->getValue());
			$item->setDamage(!isset($tag->Damage) ? 0 : $tag->Damage->getValue());
			$item->setCount($tag->Count->getValue());
		}else{
			throw new \InvalidArgumentException("Item CompoundTag ID must be an instance of StringTag or ShortTag, " . get_class($tag->id) . " given");
		}

		if(isset($tag->tag) and $tag->tag instanceof CompoundTag){
			$item->setNamedTag($tag->tag);
		}

		return $item;
	}

	final public function jsonSerialize(){
		return [
			"id" => $this->id,
			"damage" => $this->meta,
			"count" => $this->count, //TODO: separate items and stacks
			"nbt" => $this->tags
		];
	}

}
