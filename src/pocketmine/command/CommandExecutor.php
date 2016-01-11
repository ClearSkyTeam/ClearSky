<?php
namespace pocketmine\command;


interface CommandExecutor{

	/**
	 * @param CommandSender $sender
	 * @param Command       $command
	 * @param string        $label
	 * @param string[]      $args
	 *
	 * @return boolean
	 */
	public function onCommand(CommandSender $sender, Command $command, $label, array $args);

}