<?php
namespace pocketmine\level\generator;

use pocketmine\block\Block;

use pocketmine\level\generator\biome\Biome;
use pocketmine\level\Level;
use pocketmine\level\SimpleChunkManager;
use pocketmine\scheduler\AsyncTask;

use pocketmine\utils\Random;

class GeneratorRegisterTask extends AsyncTask{

	public $generator;
	public $settings;
	public $seed;
	public $levelId;

	public function __construct(Level $level, Generator $generator){
		$this->generator = get_class($generator);
		$this->settings = serialize($generator->getSettings());
		$this->seed = $level->getSeed();
		$this->levelId = $level->getId();
	}

	public function onRun(){
		Block::init();
		Biome::init();
		$manager = new SimpleChunkManager($this->seed);
		$this->saveToThreadStore("generation.level{$this->levelId}.manager", $manager);
		/** @var Generator $generator */
		$generator = $this->generator;
		$generator = new $generator(unserialize($this->settings));
		$generator->init($manager, new Random($manager->getSeed()));
		$this->saveToThreadStore("generation.level{$this->levelId}.generator", $generator);
	}
}
