<?php
namespace pocketmine\event\server;

use pocketmine\command\CommandSender;
use pocketmine\event\Cancellable;

/**
 * Called when the console runs a command, early in the process
 *
 * You don't want to use this except for a few cases like logging commands,
 * blocking commands on certain places, or applying modifiers.
 *
 * The message contains a slash at the start
 */
class ServerCommandEvent extends ServerEvent implements Cancellable{
	public static $handlerList = null;

	/** @var string */
	protected $command;

	/** @var CommandSender */
	protected $sender;

	/**
	 * @param CommandSender $sender
	 * @param string        $command
	 */
	public function __construct(CommandSender $sender, $command){
		$this->sender = $sender;
		$this->command = $command;
	}

	/**
	 * @return CommandSender
	 */
	public function getSender(){
		return $this->sender;
	}

	/**
	 * @return string
	 */
	public function getCommand(){
		return $this->command;
	}

	/**
	 * @param string $command
	 */
	public function setCommand($command){
		$this->command = $command;
	}

}