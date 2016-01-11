<?php
namespace pocketmine\command;

interface PluginIdentifiableCommand{

	/**
	 * @return \pocketmine\plugin\Plugin
	 */
	public function getPlugin();
}
