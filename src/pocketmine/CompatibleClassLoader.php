<?php
namespace pocketmine;

class CompatibleClassLoader extends \BaseClassLoader{

	/**
	 * @deprecated
	 */
	public function add($namespace, $paths){
		$this->addPath(array_shift($paths));
	}
}