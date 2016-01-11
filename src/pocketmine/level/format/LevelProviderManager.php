<?php
namespace pocketmine\level\format;

use pocketmine\Server;
use pocketmine\utils\LevelException;

abstract class LevelProviderManager{
	protected static $providers = [];

	/**
	 * @param Server $server
	 * @param string $class
	 *
	 * @throws LevelException
	 */
	public static function addProvider(Server $server, $class){
		if(!is_subclass_of($class, LevelProvider::class)){
			throw new LevelException("Class is not a subclass of LevelProvider");
		}
		/** @var LevelProvider $class */
		self::$providers[strtolower($class::getProviderName())] = $class;
	}

	/**
	 * Returns a LevelProvider class for this path, or null
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	public static function getProvider($path){
		foreach(self::$providers as $provider){
			/** @var $provider LevelProvider */
			if($provider::isValid($path)){
				return $provider;
			}
		}

		return null;
	}

	public static function getProviderByName($name){
		$name = trim(strtolower($name));

		return isset(self::$providers[$name]) ? self::$providers[$name] : null;
	}
}