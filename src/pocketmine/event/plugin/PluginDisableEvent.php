<?php

namespace pocketmine\event\plugin;

use pocketmine\plugin\Plugin;


class PluginDisableEvent extends PluginEvent{
	public static $handlerList = null;

	/**
	 * @param Plugin $plugin
	 */
	public function __construct(Plugin $plugin){
		parent::__construct($plugin);
	}
}
