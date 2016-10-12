<?php

namespace pocketmine\level\generator\biome;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\normal\biome\SwampBiome;
use pocketmine\level\generator\normal\biome\DesertBiome;
use pocketmine\level\generator\normal\biome\ForestBiome;
use pocketmine\level\generator\normal\biome\IcePlainsBiome;
use pocketmine\level\generator\normal\biome\MountainsBiome;
use pocketmine\level\generator\normal\biome\OceanBiome;
use pocketmine\level\generator\normal\biome\PlainBiome;
use pocketmine\level\generator\normal\biome\RiverBiome;
use pocketmine\level\generator\normal\biome\SavannaBiome;
use pocketmine\level\generator\normal\biome\SmallMountainsBiome;
use pocketmine\level\generator\normal\biome\TaigaBiome;
use pocketmine\level\generator\hell\HellBiome;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;
use pocketmine\level\generator\normal\biome\MesaBiome;
use pocketmine\level\generator\normal\biome\MushroomBiome;

abstract class Biome{
	const OCEAN = 0;
	const PLAINS = 1;
	const DESERT = 2;
	const MOUNTAINS = 3;
	const FOREST = 4;
	const TAIGA = 5;
	const SWAMP = 6;
	const RIVER = 7;
	const HELL = 8;
	/*
    SWAMPLAND,
    FOREST,
    TAIGA,
    DESERT,
    PLAINS,
    HELL,
    SKY,
    OCEAN,
    RIVER,
    EXTREME_HILLS,
    FROZEN_OCEAN,
    FROZEN_RIVER,
    ICE_PLAINS,
    ICE_MOUNTAINS,
    MUSHROOM_ISLAND,*/
    const MUSHROOM_SHORE = 11;/*,
    BEACH,
    DESERT_HILLS,
    FOREST_HILLS,
    TAIGA_HILLS,
    SMALL_MOUNTAINS,
    JUNGLE,
    JUNGLE_HILLS,
    JUNGLE_EDGE,
    DEEP_OCEAN,
    STONE_BEACH,
    COLD_BEACH,
    BIRCH_FOREST,
    BIRCH_FOREST_HILLS,
    ROOFED_FOREST,
    COLD_TAIGA,
    COLD_TAIGA_HILLS,
    MEGA_TAIGA,
    MEGA_TAIGA_HILLS,
    EXTREME_HILLS_PLUS,*/
    const SAVANNA = 9;/* //todo fix this number
    SAVANNA_PLATEAU,*/
    const MESA = 10;/* //todo fix this number
    MESA_PLATEAU_FOREST,
    MESA_PLATEAU,
    SUNFLOWER_PLAINS,
    DESERT_MOUNTAINS,
    FLOWER_FOREST,
    TAIGA_MOUNTAINS,
    SWAMPLAND_MOUNTAINS,
    ICE_PLAINS_SPIKES,
    JUNGLE_MOUNTAINS,
    JUNGLE_EDGE_MOUNTAINS,
    COLD_TAIGA_MOUNTAINS,
    SAVANNA_MOUNTAINS,
    SAVANNA_PLATEAU_MOUNTAINS,
    MESA_BRYCE,
    MESA_PLATEAU_FOREST_MOUNTAINS,
    MESA_PLATEAU_MOUNTAINS,
    BIRCH_FOREST_MOUNTAINS,
    BIRCH_FOREST_HILLS_MOUNTAINS,
    ROOFED_FOREST_MOUNTAINS,
    MEGA_SPRUCE_TAIGA,
    EXTREME_HILLS_MOUNTAINS,
    EXTREME_HILLS_PLUS_MOUNTAINS,
    MEGA_SPRUCE_TAIGA_HILLS,
    */
	const ICE_PLAINS = 12;
	const SMALL_MOUNTAINS = 20;
	const BIRCH_FOREST = 27;
	const MAX_BIOMES = 256;

	/** @var Biome[] */
	private static $biomes = [];

	private $id;
	private $registered = false;
	/** @var Populator[] */
	private $populators = [];

	private $minElevation;
	private $maxElevation;

	private $groundCover = [];

	protected $rainfall = 0.5;
	protected $temperature = 0.5;
	protected $grassColor = 0;

	protected static function register($id, Biome $biome){
		self::$biomes[(int) $id] = $biome;
		$biome->setId((int) $id);
		$biome->grassColor = self::generateBiomeColor($biome->getTemperature(), $biome->getRainfall());
	}

	public static function init(){
		self::register(self::OCEAN, new OceanBiome());
		self::register(self::PLAINS, new PlainBiome());
		self::register(self::DESERT, new DesertBiome());
		self::register(self::MOUNTAINS, new MountainsBiome());
		self::register(self::FOREST, new ForestBiome());
		self::register(self::TAIGA, new TaigaBiome());
		self::register(self::SWAMP, new SwampBiome());
		self::register(self::RIVER, new RiverBiome());

		self::register(self::ICE_PLAINS, new IcePlainsBiome());


		self::register(self::SMALL_MOUNTAINS, new SmallMountainsBiome());
		self::register(self::HELL, new HellBiome());

		self::register(self::BIRCH_FOREST, new ForestBiome(ForestBiome::TYPE_BIRCH));

		self::register(self::SAVANNA, new SavannaBiome());
		self::register(self::MESA, new MesaBiome());
		self::register(self::MUSHROOM_SHORE, new MushroomBiome());
	}

	/**
	 * @param $id
	 *
	 * @return Biome
	 */
	public static function getBiome($id){
		return isset(self::$biomes[$id]) ? self::$biomes[$id] : self::$biomes[self::OCEAN];
	}

	public function clearPopulators(){
		$this->populators = [];
	}

	public function addPopulator(Populator $populator){
		$this->populators[] = $populator;
	}

	public function populateChunk(ChunkManager $level, $chunkX, $chunkZ, Random $random){
		foreach($this->populators as $populator){
			$populator->populate($level, $chunkX, $chunkZ, $random);
		}
	}

	public function getPopulators(){
		return $this->populators;
	}

	public function setId($id){
		if(!$this->registered){
			$this->registered = true;
			$this->id = $id;
		}
	}

	public function getId(){
		return $this->id;
	}

	public abstract function getName();

	public function getMinElevation(){
		return $this->minElevation;
	}

	public function getMaxElevation(){
		return $this->maxElevation;
	}

	public function setElevation($min, $max){
		$this->minElevation = $min;
		$this->maxElevation = $max;
	}

	/**
	 * @return Block[]
	 */
	public function getGroundCover(){
		return $this->groundCover;
	}

	/**
	 * @param Block[] $covers
	 */
	public function setGroundCover(array $covers){
		$this->groundCover = $covers;
	}

	public function getTemperature(){
		return $this->temperature;
	}

	public function getRainfall(){
		return $this->rainfall;
	}

	private static function generateBiomeColor($temperature, $rainfall){
		$x = (1 - $temperature) * 255;
		$z = (1 - $rainfall * $temperature) * 255;
		$c = self::interpolateColor(256, $x, $z, [0x47, 0xd0, 0x33], [0x6c, 0xb4, 0x93], [0xbf, 0xb6, 0x55], [0x80, 0xb4, 0x97]);
		return ((int) ($c[0] << 16)) | (int) (($c[1] << 8)) | (int) ($c[2]);
	}


	private static function interpolateColor($size, $x, $z, $c1, $c2, $c3, $c4){
		$l1 = self::lerpColor($c1, $c2, $x / $size);
		$l2 = self::lerpColor($c3, $c4, $x / $size);

		return self::lerpColor($l1, $l2, $z / $size);
	}

	private static function lerpColor($a, $b, $s){
		$invs = 1 - $s;
		return [$a[0] * $invs + $b[0] * $s, $a[1] * $invs + $b[1] * $s, $a[2] * $invs + $b[2] * $s];
	}


	/**
	 * @return int (Red|Green|Blue)
	 */
	abstract public function getColor();
}