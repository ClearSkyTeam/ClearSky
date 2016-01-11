<?php
namespace pocketmine\event\player;

use pocketmine\event\Event;
use pocketmine\network\SourceInterface;
use pocketmine\Player;

/**
 * Allows the creation of players overriding the base Player class
 */
class PlayerCreationEvent extends Event{
	public static $handlerList = null;

	/** @var SourceInterface */
	private $interface;
	/** @var mixed */
	private $clientId;
	/** @var string */
	private $address;
	/** @var int */
	private $port;

	/** @var Player::class */
	private $baseClass;
	/** @var Player::class */
	private $playerClass;

	/**
	 * @param SourceInterface $interface
	 * @param Player::class   $baseClass
	 * @param Player::class   $playerClass
	 * @param mixed           $clientId
	 * @param string          $address
	 * @param int             $port
	 */
	public function __construct(SourceInterface $interface, $baseClass, $playerClass, $clientId, $address, $port){
		$this->interface = $interface;
		$this->clientId = $clientId;
		$this->address = $address;
		$this->port = $port;

		if(!is_a($baseClass, Player::class, true)){
			throw new \RuntimeException("Base class $baseClass must extend " . Player::class);
		}

		$this->baseClass = $baseClass;

		if(!is_a($playerClass, Player::class, true)){
			throw new \RuntimeException("Class $playerClass must extend " . Player::class);
		}

		$this->playerClass = $playerClass;
	}

	/**
	 * @return SourceInterface
	 */
	public function getInterface(){
		return $this->interface;
	}

	/**
	 * @return string
	 */
	public function getAddress(){
		return $this->address;
	}

	/**
	 * @return int
	 */
	public function getPort(){
		return $this->port;
	}

	/**
	 * @return mixed
	 */
	public function getClientId(){
		return $this->clientId;
	}

	/**
	 * @return Player::class
	 */
	public function getBaseClass(){
		return $this->baseClass;
	}

	/**
	 * @param Player::class $class
	 */
	public function setBaseClass($class){
		if(!is_a($class, $this->baseClass, true)){
			throw new \RuntimeException("Base class $class must extend " . $this->baseClass);
		}

		$this->baseClass = $class;
	}

	/**
	 * @return Player::class
	 */
	public function getPlayerClass(){
		return $this->playerClass;
	}

	/**
	 * @param Player::class $class
	 */
	public function setPlayerClass($class){
		if(!is_a($class, $this->baseClass, true)){
			throw new \RuntimeException("Class $class must extend " . $this->baseClass);
		}

		$this->playerClass = $class;
	}

}