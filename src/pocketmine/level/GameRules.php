<?php

namespace pocketmine\level;

/*
 * import java.util.Set;
 * import java.util.TreeMap;
 */
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;

class GameRules{
	const ANY_VALUE = 0;
	const BOOLEAN_VALUE = 1;
	const NUMERICAL_VALUE = 2;

	private $theGameRules = [];

	public function __construct(){
		$this->addGameRule("doFireTick", true, self::BOOLEAN_VALUE);
		$this->addGameRule("mobGriefing", true, self::BOOLEAN_VALUE);
		$this->addGameRule("keepInventory", false, self::BOOLEAN_VALUE);
		$this->addGameRule("doMobSpawning", true, self::BOOLEAN_VALUE);
		$this->addGameRule("doMobLoot", true, self::BOOLEAN_VALUE);
		$this->addGameRule("doTileDrops", true, self::BOOLEAN_VALUE);
		$this->addGameRule("doEntityDrops", true, self::BOOLEAN_VALUE);
		$this->addGameRule("commandBlockOutput", true, self::BOOLEAN_VALUE);
		$this->addGameRule("naturalRegeneration", true, self::BOOLEAN_VALUE);
		$this->addGameRule("doDaylightCycle", true, self::BOOLEAN_VALUE);
		$this->addGameRule("logAdminCommands", true, self::BOOLEAN_VALUE);
		$this->addGameRule("showDeathMessages", true, self::BOOLEAN_VALUE);
		$this->addGameRule("randomTickSpeed", 3, self::NUMERICAL_VALUE);
		$this->addGameRule("sendCommandFeedback", true, self::BOOLEAN_VALUE);
		$this->addGameRule("reducedDebugInfo", false, self::BOOLEAN_VALUE);
		$this->addGameRule("spectatorsGenerateChunks", true, self::BOOLEAN_VALUE);
		$this->addGameRule("spawnRadius", 10, self::NUMERICAL_VALUE);
		$this->addGameRule("disableElytraMovementCheck", false, self::BOOLEAN_VALUE);
	}

	public function addGameRule($key, $value, $type){
		if($type == self::BOOLEAN_VALUE){
			$this->theGameRules[$key] = new ByteTag($key, $value);
		}elseif($type == self::NUMERICAL_VALUE){
			$this->theGameRules[$key] = new IntTag($key, $value);
		}else{
			$this->theGameRules[$key] = new StringTag($key, $value);
		}
		#$rule = array($value, $type);
		#$this->theGameRules[$key] = $rule;
	}

	public function setOrCreateGameRule($key, $ruleValue){
		$value = $this->theGameRules[$key];
		
		if($value != null){
			$this->theGameRules[$key] = $ruleValue;
		}
		else{
			$this->addGameRule($key, $ruleValue, self::ANY_VALUE);
		}
	}

	/**
	 * Gets the string Game Rule value.
	 */
	public function getString($name){
		$value = $this->theGameRules[$name];
		return $value != null?$value:""; // ?
	}

	/**
	 * Gets the boolean Game Rule value.
	 */
	public function getBoolean($name){
		$value = $this->theGameRules[$name];
		return $value != null?$value:false; // ?
	}

	public function getInt($name){
		$value = $this->theGameRules[$name];
		return $value != null?$value:0; // ?
	}

	/**
	 * Return the defined game rules as NBT.
	 */
	public function writeToNBT(){
		$nbttagcompound = new CompoundTag();
		
		foreach($this->theGameRules as $s){
			$value = $this->theGameRules[$s];
			$nbttagcompound->setValue($s, $value);
		}
		
		return $nbttagcompound;
	}

	/**
	 * Set defined game rules from NBT.
	 */
	// wtf -.-
	public function readFromNBT(CompoundTag $nbt){
		foreach($nbt->getValue() as $s){
			$s1 = $nbt->getValue($s);
			$this->setOrCreateGameRule($s, $s1);
		}
	}

	/**
	 * Return the defined game rules.
	 */
	public function getRules(){
		#return [];
		return $this->theGameRules;
	}

	/**
	 * Return whether the specified game rule is defined.
	 */
	public function hasRule($name){
		return in_array($name, $this->theGameRules);
	}

	public function areSameType($key, $otherValue){
		$value = $this->theGameRules[$key];
		return $value != null && ($value[1] == $otherValue || $otherValue == self::ANY_VALUE);
	}
}