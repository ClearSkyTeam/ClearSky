<?php
namespace pocketmine\metadata;

use pocketmine\plugin\Plugin;

abstract class MetadataValue{
	/** @var Plugin */
	private $owningPlugin;

	protected function __construct(Plugin $owningPlugin){
        $this->owningPlugin = new \WeakRef($owningPlugin);
	}

	/**
	 * @return Plugin
	 */
	public function getOwningPlugin(){
		return $this->owningPlugin->get();
	}

	/**
	 * Fetches the value of this metadata item.
	 *
	 * @return mixed
	 */
	public abstract function value();

	/**
	 * Invalidates this metadata item, forcing it to recompute when next
	 * accessed.
	 */
	public abstract function invalidate();
}