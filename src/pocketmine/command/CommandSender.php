<?php
namespace pocketmine\command;

use pocketmine\permission\Permissible;

interface CommandSender extends Permissible{

	/**
	 * @param string $message
	 */
	public function sendMessage($message);

	/**
	 * @return \pocketmine\Server
	 */
	public function getServer();

	/**
	 * @return string
	 */
	public function getName();


}