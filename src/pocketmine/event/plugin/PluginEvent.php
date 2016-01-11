<?php
/**
 * Events related Plugin enable / disable events
 */
namespace pocketmine\event\plugin;

use pocketmine\event\Event;
use pocketmine\plugin\Plugin;


abstract class PluginEvent extends Event{

	/** @var Plugin */
	private $plugin;

	public function __construct(Plugin $plugin){
		$this->plugin = $plugin;
	}

	/**
	 * @return Plugin
	 */
	public function getPlugin(){
		return $this->plugin;
	}
}
