<?php
namespace pocketmine\scheduler;

use pocketmine\plugin\Plugin;

/**
 * Base class for plugin tasks. Allows the Server to delete them easily when needed
 */
abstract class PluginTask extends Task{

	/** @var Plugin */
	protected $owner;

	/**
	 * @param Plugin $owner
	 */
	public function __construct(Plugin $owner){
		$this->owner = $owner;
	}

	/**
	 * @return Plugin
	 */
	public final function getOwner(){
		return $this->owner;
	}

}
