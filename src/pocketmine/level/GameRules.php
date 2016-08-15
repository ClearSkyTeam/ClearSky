<?php

namespace pocketmine\level;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\Tag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\IntArrayTag;

class GameRules{
	private $theGameRules = [];

	public function __construct(CompoundTag $rules = null){
		print(is_null($rules)?"true\n":"false\n");
		$this->addGameRule("doFireTick", true, ByteTag::class);
		$this->addGameRule("mobGriefing", true, ByteTag::class);
		$this->addGameRule("keepInventory", false, ByteTag::class);
		$this->addGameRule("doMobSpawning", true, ByteTag::class);
		$this->addGameRule("doMobLoot", true, ByteTag::class);
		$this->addGameRule("doTileDrops", true, ByteTag::class);
		$this->addGameRule("doEntityDrops", true, ByteTag::class);
		$this->addGameRule("commandBlockOutput", true, ByteTag::class);
		$this->addGameRule("naturalRegeneration", true, ByteTag::class);
		$this->addGameRule("doDaylightCycle", true, ByteTag::class);
		$this->addGameRule("logAdminCommands", true, ByteTag::class);
		$this->addGameRule("showDeathMessages", true, ByteTag::class);
		$this->addGameRule("randomTickSpeed", 3, IntTag::class);
		$this->addGameRule("sendCommandFeedback", true, ByteTag::class);
		$this->addGameRule("reducedDebugInfo", false, ByteTag::class);
		$this->addGameRule("spectatorsGenerateChunks", true, ByteTag::class);
		$this->addGameRule("spawnRadius", 10, IntTag::class);
		$this->addGameRule("disableElytraMovementCheck", false, ByteTag::class);
		if(!is_null($rules)) $this->readFromNBT($rules);
		// var_dump($this->writeToNBT());
	}

	public function addGameRule($key, $value){
		$this->theGameRules[$key] = $value;
	}

	public function setOrCreateGameRule($key, $ruleValue){
		print("setting " . $key . " to " . $ruleValue . "\n");
		$value = $this->theGameRules[$key];
		
		if($value != null){
			$this->theGameRules[$key] = $ruleValue;
		}
		else{
			$this->addGameRule($key, $ruleValue, Tag::class);
		}
	}

	/**
	 * Return the defined game rules as NBT.
	 */
	public function writeToNBT(){
		$compoundarray = [];
		foreach($this->theGameRules as $key => $value){
			$compoundarray[] = NBT::fromArrayGuesser($key, $value);
		}
		$nbttagcompound = new CompoundTag("GameRules", $compoundarray);
		return $nbttagcompound;
	}

	/**
	 * Set defined game rules from NBT.
	 */
	public function readFromNBT(CompoundTag $nbt){
		print("setting values\n");
		$data = [];
		self::toArray($data, $nbt);
		foreach($data as $key => $value){
			$this->setOrCreateGameRule($key, $value);
		}
	}

	/**
	 * Return the defined game rules.
	 *
	 * @return CompoundTag
	 */
	public function getRules(){
		return $this->writeToNBT();
	}

	/**
	 * Return the defined game rules as array
	 */
	public function getRulesArray(){
		$data = [];
		NBT::toArray($data, $this->theGameRules);
		return $data;
	}

	/**
	 * Return whether the specified game rule is defined.
	 */
	public function hasRule($name){
		return in_array($name, $this->theGameRules);
	}

	public function areSameType($key, $otherValue){
		$value = $this->theGameRules[$key];
		return $value != null && (gettype($value) == gettype($otherValue));
	}

	private static function toArray(array &$data, Tag $tag){
		/** @var CompoundTag[]|ListTag[]|IntArrayTag[] $tag */
		foreach($tag as $key => $value){
			if($value instanceof CompoundTag or $value instanceof ListTag or $value instanceof IntArrayTag){
				$data[$key] = [];
				self::toArray($data[$key], $value);
			}
			else{
				$data[$key] = $value->getValue();
			}
		}
	}
}