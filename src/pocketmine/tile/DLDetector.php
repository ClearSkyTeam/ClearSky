<?php

namespace pocketmine\tile;

use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\level\Level;

class DLDetector extends Spawnable{

	public function __construct(FullChunk $chunk, CompoundTag $nbt){
		parent::__construct($chunk, $nbt);
		$this->getLevel()->scheduleUpdate($this, 0);
	}

	public function getLightByTime(){
		$strength = 0;
		$time = $this->getLevel()->getTime() % Level::TIME_FULL;
		// if(WeatherManager::isRegistered($this->getLevel())) $weather = $this->getLevel()->getWeather()->getWeather();
		/* else */
		$a = 1;
		switch($a){
			case $a:
				if($time <= 22340 and $time >= 13680) $strength = 1;
				if($time <= 22800 and $time >= 13220) $strength = 2;
				if($time <= 23080 and $time >= 12940) $strength = 3;
				if($time <= 23300 and $time >= 12720) $strength = 4;
				if($time <= 23540 and $time >= 12480) $strength = 5;
				if($time <= 23780 and $time >= 12240) $strength = 6;
				if($time <= 23960 and $time >= 12040) $strength = 7;
				if($time >= 180 and $time <= 11840) $strength = 8;
				if($time >= 540 and $time <= 11480) $strength = 9;
				if($time >= 940 and $time <= 11080) $strength = 10;
				if($time >= 1380 and $time <= 10640) $strength = 11;
				if($time >= 1880 and $time <= 10140) $strength = 12;
				if($time >= 2460 and $time <= 9560) $strength = 13;
				if($time >= 3180 and $time <= 8840) $strength = 14;
				if($time >= 4300 and $time <= 7720) $strength = 15;
				break;
			case self::RAINY_THUNDER:
			case self::RAINY:
				if($time <= 22340 and $time >= 13680) $strength = 1;
				if($time <= 22800 and $time >= 13220) $strength = 2;
				if($time <= 23240 and $time >= 12780) $strength = 3;
				if($time <= 23520 and $time >= 12500) $strength = 4;
				if($time <= 23760 and $time >= 12260) $strength = 5;
				if($time >= 0 and $time <= 12020) $strength = 6;
				if($time >= 400 and $time <= 11620) $strength = 7;
				if($time >= 900 and $time <= 11120) $strength = 8;
				if($time >= 1440 and $time <= 10580) $strength = 9;
				if($time >= 2080 and $time <= 9940) $strength = 10;
				if($time >= 2880 and $time <= 9140) $strength = 11;
				if($time >= 4120 and $time <= 7990) $strength = 12;
				break;
		}
		return $strength;
	}

	public function getPower(){
		return $this->getLightByTime() + 1;
	}

	public function getSpawnCompound(){
		return new CompoundTag("", [new StringTag("id", Tile::DAY_LIGHT_DETECTOR), new IntTag("x", (int) $this->x), new IntTag("y", (int) $this->y), new IntTag("z", (int) $this->z)]);
	}
}
